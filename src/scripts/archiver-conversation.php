<?php

if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

if (empty($_GET['id_channel'])) {
    header('Location: /');
    exit;
}

$query = $dbh->prepare("UPDATE channel SET est_actif = 0 WHERE id_channel = :id_channel");
$query->execute([
    'id_channel' => $_GET['id_channel'],
]);
