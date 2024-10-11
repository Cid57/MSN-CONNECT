<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Cela permet de garder les informations sur l'utilisateur entre les pages
}

// Vérifier si l'utilisateur est connecté et s'il a des droits d'administrateur
if (empty($_SESSION['id_utilisateur'])) {
    // Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
    header('Location: /?page=connexion');
    exit; // Stoppe l'exécution du script après redirection
}

if ($_SESSION['est_admin'] == 0) {
    // Si l'utilisateur connecté n'est pas un administrateur, redirection vers la page d'accueil
    header('Location: /');
    exit;
}

$success = ''; // Variable pour stocker les messages de succès

// Vérifier si le formulaire d'inscription a été soumis
if (isset($_POST['inscription_admin_bouton'])) {
    $errors = []; // Initialiser un tableau pour les messages d'erreurs

    // Validation des champs prénom, nom, email
    $prenom = !empty($_POST['inscription_prenom']) ? $_POST['inscription_prenom'] : $errors['prenom'] = 'Le champ "prénom" est obligatoire.';
    $nom = !empty($_POST['inscription_nom']) ? $_POST['inscription_nom'] : $errors['nom'] = 'Le champ "nom" est obligatoire.';

    // Vérifier si l'email est valide
    if (!empty($_POST['inscription_email'])) {
        if (filter_var($_POST['inscription_email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['inscription_email'];
        } else {
            $errors['email'] = 'Le champ email n\'est pas valide.'; // Message d'erreur si email invalide
        }
    } else {
        $errors['email'] = 'Le champ "email" est obligatoire.'; // Message d'erreur si le champ email est vide
    }

    // Si aucune erreur n'a été trouvée, on procède à l'insertion dans la base de données
    if (empty($errors)) {
        // Insertion d'un nouvel utilisateur dans la table 'utilisateur' sans mot de passe (à définir via un lien envoyé par email)
        $query = $dbh->prepare("INSERT INTO utilisateur (prenom, nom, email, date_de_creation, est_admin, est_actif)
VALUES (:prenom, :nom, :email, NOW(), :est_admin, 1)");
        $query->execute([
            'prenom' => $prenom,
            'nom' => $nom,
            'email' => $email,
            'est_admin' => isset($_POST['inscription_admin']) ? 1 : 0 // Définir si l'utilisateur est administrateur ou non
        ]);

        // Génération d'un token de réinitialisation de mot de passe pour sécuriser la création du mot de passe
        $token = bin2hex(random_bytes(32)); // Générer un token unique
        $expires = date("U") + 3600; // Définir l'expiration du token (1 heure)

        // Supprimer les anciens tokens pour cet utilisateur s'il en existe
        $dbh->prepare("DELETE FROM password_reset WHERE email = ?")->execute([$email]);

        // Insérer le nouveau token dans la table 'password_reset'
        $query = $dbh->prepare("INSERT INTO password_reset (email, token, expires) VALUES (?, ?, ?)");
        $query->execute([$email, $token, $expires]);

        // Envoi du lien de réinitialisation par mail
        $reset_link = "http://msn-connect/?page=reset_password&token=" . $token . "&email=" . urlencode($email);
        $to = $email; // L'email de l'utilisateur nouvellement créé
        $subject = "Définir votre mot de passe MSN Connect";
        $subject_encoded = mb_encode_mimeheader($subject, 'UTF-8');

        // Message de contenu de l'email avec le lien pour définir le mot de passe
        $message_content = "Bonjour,\n\nUn compte a été créé pour vous. Veuillez définir votre mot de passe en cliquant sur le lien suivant :\n\n";
        $message_content .= $reset_link . "\n\nCe lien expirera dans une heure.\n\nCordialement,\nMSN Connect";

        // En-têtes de l'email
        $headers = "From: cindy.singer@stagiairesmns.fr\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

        // Envoi de l'email
        if (mail($to, $subject_encoded, $message_content, $headers)) {
            $success = "Un lien de réinitialisation de mot de passe a été envoyé à l'utilisateur.";
        } else {
            $errors['mail'] = "Une erreur est survenue lors de l'envoi de l'e-mail.";
        }
    }
}
