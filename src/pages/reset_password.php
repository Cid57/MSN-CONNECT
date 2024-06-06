<?php

$message = "";

if (isset($_GET['token']) && isset($_GET['email'])) {
    $token = $_GET['token'];
    $email = $_GET['email'];

    // Vérifier si le token est valide et n'a pas expiré
    $requete = $dbh->prepare("SELECT * FROM password_reset WHERE email = ? AND token = ? AND expires > ?");
    $requete->execute([$email, $token, date("U")]);
    $reset_request = $requete->fetch();

    if ($reset_request) {
        // Le token est valide, afficher le formulaire de réinitialisation du mot de passe
        if (isset($_POST['reset_password'])) {
            $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe de l'utilisateur
            $requete = $dbh->prepare("UPDATE utilisateur SET password = ? WHERE email = ?");
            $requete->execute([$new_password, $email]);

            // Supprimer le token de réinitialisation de la base de données
            $requete = $dbh->prepare("DELETE FROM password_reset WHERE email = ?");
            $requete->execute([$email]);

            $message = "Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.";
        }
    } else {
        $message = "Le lien de réinitialisation est invalide ou a expiré.";
    }
} else {
    header('Location: /');
    exit;
}
