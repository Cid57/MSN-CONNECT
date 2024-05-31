<?php

if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

// Récupérer tous les groupes
$stmt = $dbh->prepare("SELECT id_channel, nom_du_channel FROM channel WHERE nom_du_channel IS NOT NULL");
$stmt->execute();
$channels = $stmt->fetchAll();

