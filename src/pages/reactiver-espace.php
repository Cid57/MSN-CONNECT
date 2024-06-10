<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

if ($_SESSION['est_admin'] == 0) {
    header('Location: /');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['submit_button'])) {
    if (!empty($_POST['espace']) && is_array($_POST['espace'])) {
        $ids_placeholders = implode(',', array_fill(0, count($_POST['espace']), '?'));

        $query = $dbh->prepare("UPDATE channel SET est_actif = 1 WHERE id_channel IN ($ids_placeholders)");
        $query->execute($_POST['espace']);

        $_SESSION['message'] = "Les groupes sélectionnés ont été réactivés avec succès.";
        header('Location: /?page=reactiver-espace');
        exit;
    } else {
        $message = "Veuillez sélectionner au moins un groupe.";
    }
}

// Récupérer la liste des groupes désactivés
$query = $dbh->query("SELECT id_channel, nom_du_channel FROM channel WHERE est_actif = 0");
$espaces = $query->fetchAll();

$message = $message ?: ($_SESSION['message'] ?? '');
unset($_SESSION['message']);
