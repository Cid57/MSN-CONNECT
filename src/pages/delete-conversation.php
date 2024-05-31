<?php

// Vérifier si l'utilisateur est connecté
if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

// Récupérer l'ID de l'utilisateur connecté et l'ID du canal
$idUtilisateur = $_SESSION['id_utilisateur'];
$idChannel = isset($_GET['id_channel']) ? (int)$_GET['id_channel'] : null;

if (!$idChannel) {
    // Si aucun canal n'est spécifié, rediriger vers la page d'accueil
    header('Location: /');
    exit;
}

// Vérifier si l'utilisateur a accès à la conversation
$query = $dbh->prepare("SELECT * FROM acces WHERE id_channel = :id_channel AND id_utilisateur = :id_utilisateur");
$query->execute(['id_channel' => $idChannel, 'id_utilisateur' => $idUtilisateur]);
$acces = $query->fetch();

if (!$acces) {
    // Si l'utilisateur n'a pas accès à la conversation, rediriger vers la page d'accueil
    header('Location: /');
    exit;
}

try {
    // Supprimer les messages de la conversation
    $query = $dbh->prepare("DELETE FROM message WHERE id_channel = :id_channel");
    $query->execute(['id_channel' => $idChannel]);

    // Supprimer les accès à la conversation
    $query = $dbh->prepare("DELETE FROM acces WHERE id_channel = :id_channel");
    $query->execute(['id_channel' => $idChannel]);

    // Supprimer la conversation elle-même
    $query = $dbh->prepare("DELETE FROM channel WHERE id_channel = :id_channel");
    $query->execute(['id_channel' => $idChannel]);

    // Rediriger vers la page d'accueil après la suppression
    header('Location: /');
    exit;
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
