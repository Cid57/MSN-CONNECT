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
    if (!empty($_POST['utilisateur']) && is_array($_POST['utilisateur'])) {
        $ids_placeholders = implode(',', array_fill(0, count($_POST['utilisateur']), '?'));

        $query = $dbh->prepare("UPDATE utilisateur SET est_actif = 1 WHERE id_utilisateur IN ($ids_placeholders)");
        $query->execute($_POST['utilisateur']);

        $_SESSION['message'] = "Les utilisateurs sélectionnés ont été réactivés avec succès.";
        header('Location: /?page=reactiver-utilisateur');
        exit;
    } else {
        $message = "Veuillez sélectionner au moins un utilisateur.";
    }
}

// Récupérer la liste des utilisateurs désactivés
$query = $dbh->query("SELECT id_utilisateur, prenom, nom, email FROM utilisateur WHERE est_actif = 0");
$utilisateurs = $query->fetchAll();

$message = $message ?: ($_SESSION['message'] ?? '');
unset($_SESSION['message']);
