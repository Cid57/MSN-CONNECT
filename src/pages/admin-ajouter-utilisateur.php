<?php

// Démarrer la session si nécessaire
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté et est un administrateur
if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

if ($_SESSION['est_admin'] == 0) {
    header('Location: /');
    exit;
}

// Fonction pour générer un mot de passe aléatoire
function motDePasse($longueur=8) { // Par défaut, un mot de passe de 8 caractères
    $Chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $Chaine = str_shuffle($Chaine);
    $Chaine = substr($Chaine, 0, $longueur);
    return $Chaine;
}

$success = '';

if (isset($_POST['inscription_admin_bouton'])) {

    $errors = [];

    if (!empty($_POST['inscription_prenom'])) {
        $prenom = $_POST['inscription_prenom'];
    } else {
        $errors['prenom'] = 'Le champ \'prenom\' est obligatoire.';
    }

    if (!empty($_POST['inscription_nom'])) {
        $nom = $_POST['inscription_nom'];
    } else {
        $errors['nom'] = 'Le champ \'nom\' est obligatoire.';
    }

    if (!empty($_POST['inscription_email'])) {
        $email = $_POST['inscription_email'];
    } else {
        $errors['email'] = 'Le champ \'email\' est obligatoire.';
    }

    if (empty($errors)) {
        $query = $dbh->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $query->execute(['email' => $email]);
        $utilisateur = $query->fetch();

        if ($utilisateur) {
            if ($utilisateur['est_actif'] == 0) {
                $query = $dbh->prepare("UPDATE utilisateur SET prenom = :prenom, nom = :nom, est_admin = :est_admin, est_actif = 1 WHERE email = :email");
                $query->execute([
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'est_admin' => isset($_POST['inscription_admin']) ? 1 : 0,
                    'email' => $email
                ]);
                $success = 'L\'utilisateur a été réactivé avec succès.';
            } else {
                $errors['email'] = 'Un utilisateur avec cet email existe déjà.';
            }
        } else {
            // Générer un mot de passe aléatoire
            $motDePasse = motDePasse(8); // Génère un mot de passe de 8 caractères
            $hashedPassword = password_hash($motDePasse, PASSWORD_BCRYPT); // Hacher le mot de passe

            $query = $dbh->prepare("INSERT INTO utilisateur (prenom, nom, email, mot_de_passe, date_de_creation, est_admin, est_actif) VALUES (:prenom, :nom, :email, :mot_de_passe, NOW(), :est_admin, 1)");
            $query->execute([
                'prenom' => $prenom,
                'nom' => $nom,
                'email' => $email,
                'mot_de_passe' => $hashedPassword,
                'est_admin' => isset($_POST['inscription_admin']) ? 1 : 0
            ]);
            $success = 'L\'utilisateur a été ajouté avec succès. Son mot de passe est : ' . $motDePasse;
        }
    }
}
?>
