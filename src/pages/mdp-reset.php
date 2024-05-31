<?php

if (!empty($_SESSION['id_utilisateur'])) {
    header('Location: /');
    exit;
}

$message = [];

if (isset($_POST['reset_password'])) {
    $email = $_POST['email'];

    $requete = $dbh->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $requete->execute([$email]);

    // if ($requete->fetch()) {
    //     $token = bin2hex(random_bytes(50));
    //     $requete = $dbh->prepare("UPDATE utilisateur SET token =? WHERE email = ?");
    //     $requete->execute([$token, $email]);

    //     $message = "Un email de réinitialisation à été envoyé avec succès";
    // } else {
    //     $message = "Cette adresse email n'existe pas";
    // }
}
