<?php

if (!empty($_SESSION['id_utilisateur'])) {
    header('Location: /');
    exit;
}

// $message = [];

if (isset($_POST['reset_password'])) {
    $email = $_POST['email'];

    $requete = $dbh->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $requete->execute([$email]);
    $user = $requete->fetch();

    if ($user) {
        $to = $email;
        $subject = "Réinitialisation de mot de passe";
        $subject_encoded = mb_encode_mimeheader($subject, 'UTF-8');

        $message = "Bonjour,\n\nPour réinitialiser votre mot de passe, veuillez cliquer sur le lien suivant :\n\n";

        $message .= "Ce lien expirera dans une heure.\n\nCordialement,\nLoc MNS";

        $headers = "From: kevin.hary@laposte.net\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject_encoded, $message, $headers)) {
            echo  "Un e-mail de réinitialisation de mot de passe a été envoyé à votre adresse e-mail.";
            // header("Location: mdp_oublier.php"); // Rediriger vers la page de formulaire après envoi réussi pour éviter la soumission répétée du formulaire
            exit(); // Arrêter l'exécution du script après la redirection
        } else {
            echo "Une erreur s'est produite lors de l'envoi de l'e-mail.";
        }
    }

    // if ($requete->fetch()) {
    //     $token = bin2hex(random_bytes(50));
    //     $requete = $dbh->prepare("UPDATE utilisateur SET token =? WHERE email = ?");
    //     $requete->execute([$token, $email]);

    //     $message = "Un email de réinitialisation à été envoyé avec succès";
    // } else {
    //     $message = "Cette adresse email n'existe pas";
    // }
}
