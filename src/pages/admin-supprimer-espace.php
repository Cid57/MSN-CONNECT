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
    $ids_placeholders = implode(',', array_fill(0, count($_POST['espace']), '?'));

    $query = $dbh->prepare("UPDATE channel SET est_actif = 0 WHERE id_channel IN ($ids_placeholders)");
    $query->execute($_POST['espace']);

    // Stocker le message de confirmation dans la session
    $_SESSION['message'] = "Les espaces sélectionnés ont été supprimés avec succès.";
} else {
    $message = "Aucun espace sélectionné pour la suppression.";
}

// Récupérer la liste des groupes
$query = $dbh->query("SELECT id_channel, nom_du_channel FROM channel WHERE est_groupe = 1 AND est_actif = 1");
$espaces = $query->fetchAll();

// Récupérer le message de confirmation de la session s'il existe
$message = $_SESSION['message'] ?? '';
// Supprimer le message après l'avoir récupéré
unset($_SESSION['message']);
