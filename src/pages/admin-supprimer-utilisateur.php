<?php

if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

if ($_SESSION['est_admin'] == 0) {
    header('Location: /');
    exit;
}

if (!empty($_POST['submit_button'])) {
    $ids_placeholders = implode(',', array_fill(0, count($_POST['utilisateur']), '?'));

    $query = $dbh->prepare("UPDATE utilisateur SET est_actif = 0 WHERE id_utilisateur IN ($ids_placeholders)");
    $query->execute($_POST['utilisateur']);

    // Stocker le message de confirmation dans la session
    $_SESSION['message'] = "Les utilisateurs sélectionnés ont été supprimés avec succès.";
}

// Récupérer la liste des utilisateurs
$query = $dbh->query("SELECT id_utilisateur, prenom, nom FROM utilisateur WHERE est_actif = 1");
$utilisateurs = $query->fetchAll();

// Récupérer le message de confirmation de la session s'il existe
$message = $_SESSION['message'] ?? '';
// Supprimer le message après l'avoir récupéré
unset($_SESSION['message']);
