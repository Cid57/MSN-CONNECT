<?php

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté et a des droits d'administrateur
if (empty($_SESSION['id_utilisateur'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: /?page=connexion');
    exit;
}

if ($_SESSION['est_admin'] == 0) {
    // Rediriger vers la page d'accueil si l'utilisateur n'est pas administrateur
    header('Location: /');
    exit;
}

// Fonction pour générer un mot de passe aléatoire
function motDePasse($longueur = 8)
{ // Par défaut, un mot de passe de 8 caractères
    $Chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $Chaine = str_shuffle($Chaine); // Mélanger les caractères pour obtenir un mot de passe aléatoire
    return substr($Chaine, 0, $longueur); // Retourner une sous-chaîne de la longueur désirée
}

$success = ''; // Variable pour stocker les messages de succès

// Vérifier si le formulaire d'inscription a été soumis
if (isset($_POST['inscription_admin_bouton'])) {

    $errors = []; // Tableau pour stocker les messages d'erreur

    // Validation du champ prénom
    if (!empty($_POST['inscription_prenom'])) {
        $prenom = $_POST['inscription_prenom'];
    } else {
        $errors['prenom'] = 'Le champ \'prenom\' est obligatoire.';
    }

    // Validation du champ nom
    if (!empty($_POST['inscription_nom'])) {
        $nom = $_POST['inscription_nom'];
    } else {
        $errors['nom'] = 'Le champ \'nom\' est obligatoire.';
    }

    // Validation du champ email avec un filtre
    if (!empty($_POST['inscription_email'])) {
        if (filter_var($_POST['inscription_email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['inscription_email'];
        } else {
            $errors['email'] = 'Le champ email n\'est pas valide.';
        }
    } else {
        $errors['email'] = 'Le champ \'email\' est obligatoire.';
    }

    // Si aucun champ n'est manquant, continuer le traitement
    if (empty($errors)) {
        // Vérifier si un utilisateur avec cet email existe déjà
        $query = $dbh->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $query->execute(['email' => $email]);
        $utilisateur = $query->fetch();

        if ($utilisateur) {
            // Si l'utilisateur existe mais est inactif, le réactiver
            if ($utilisateur['est_actif'] == 0) {
                $query = $dbh->prepare("UPDATE utilisateur SET prenom = :prenom, nom = :nom, est_admin = :est_admin, 
                est_actif = 1 WHERE email = :email");
                $query->execute([
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'est_admin' => isset($_POST['inscription_admin']) ? 1 : 0, // Vérifier si l'utilisateur est admin
                    'email' => $email
                ]);
                $success = 'L\'utilisateur a été réactivé avec succès.';
            } else {
                // Si l'utilisateur est déjà actif, afficher une erreur
                $errors['email'] = 'Un utilisateur avec cet email existe déjà.';
            }



        } else {

            // Si l'utilisateur n'existe pas, créer un nouvel utilisateur
            // Générer un mot de passe aléatoire
            $motDePasse = motDePasse(8); // Génère un mot de passe de 8 caractères

            
            $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT); // Hacher le mot de passe pour la sécurité

            // Insérer le nouvel utilisateur dans la base de données


            $query = $dbh->prepare("INSERT INTO utilisateur (prenom, nom, email, mot_de_passe, date_de_creation, est_admin, est_actif) 
            VALUES (:prenom, :nom, :email, :mot_de_passe, NOW(), :est_admin, 1)");
            $query->execute([
                'prenom' => $prenom,
                'nom' => $nom,
                'email' => $email,
                'mot_de_passe' => $hashedPassword, // Stocker le mot de passe haché
                'est_admin' => isset($_POST['inscription_admin']) ? 1 : 0 // Définir le rôle de l'utilisateur
            ]);
            $success = 'L\'utilisateur a été ajouté avec succès. Son mot de passe est : ' . $motDePasse; 
            // Afficher le mot de passe généré
        }
    }
}


