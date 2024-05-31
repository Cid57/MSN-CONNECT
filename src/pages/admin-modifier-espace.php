<?php

if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

if ($_SESSION['est_admin'] == 0) {
    header('Location: /');
    exit;
}

$afficherFormulaire = false; // Par défaut, ne pas afficher le formulaire
$message = "";

$query = $dbh->query("SELECT id_channel, nom_du_channel FROM channel WHERE est_groupe = 1");
$channels = $query->fetchAll();


