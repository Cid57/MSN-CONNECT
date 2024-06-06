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
    if (!empty($_POST['groupe']) && is_array($_POST['groupe'])) {
        $ids_placeholders = implode(',', array_fill(0, count($_POST['groupe']), '?'));

        $query = $dbh->prepare("UPDATE channel SET est_actif = 1 WHERE id_channel IN ($ids_placeholders)");
        $query->execute($_POST['groupe']);

        $_SESSION['message'] = "Les groupes sélectionnés ont été réactivés avec succès.";
        header('Location: /?page=reactiver-espace');
        exit;
    } else {
        $message = "Veuillez sélectionner au moins un groupe.";
    }
}

// Récupérer la liste des groupes désactivés
$query = $dbh->prepare("SELECT id_channel, nom_du_channel FROM channel WHERE est_actif = 0 AND est_groupe = 1");
$query->execute();
$groupes = $query->fetchAll();

// Vérification des résultats de la requête
var_dump($groupes);

$message = $message ?: ($_SESSION['message'] ?? '');
unset($_SESSION['message']);
