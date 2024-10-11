<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['email']) && isset($_GET['token'])) {
    $utilisateur = $dbh->prepare("SELECT * FROM password_reset WHERE email = :email && token = :token");
    $utilisateur->execute(['email' => $_GET['email'], 'token' => $_GET['token']]);
    $user = $utilisateur->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_password'])) {

        if ($user) {

            $stmt = $dbh->prepare("UPDATE utilisateur SET mot_de_passe = :mot_de_passe WHERE email = :email");
            $stmt->execute(['mot_de_passe' => password_hash($_POST['new_password'], PASSWORD_DEFAULT), 'email' => $user['email']]);
        }

        header('Location: /?page=connexion');
        exit;
    }
}
