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
$id_channel = filter_input(INPUT_GET, 'id_channel', FILTER_SANITIZE_NUMBER_INT);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['submit_button'])) {
    if (!empty($_POST['utilisateur']) && is_array($_POST['utilisateur'])) {
        $ids_placeholders = implode(',', array_fill(0, count($_POST['utilisateur']), '?'));

        $query = $dbh->prepare("DELETE FROM acces WHERE id_channel = ? AND id_utilisateur IN ($ids_placeholders)");
        $query->execute(array_merge([$id_channel], $_POST['utilisateur']));

        $_SESSION['message'] = "Les utilisateurs sélectionnés ont été supprimés du groupe avec succès.";
        header("Location: /?page=supprimer-utilisateur-groupe&id_channel=$id_channel");
        exit;
    } else {
        $message = "Veuillez sélectionner au moins un utilisateur.";
    }
}

// Récupérer la liste des utilisateurs du groupe
$query = $dbh->prepare("SELECT utilisateur.id_utilisateur, utilisateur.prenom, utilisateur.nom, utilisateur.email 
                        FROM utilisateur 
                        JOIN acces ON utilisateur.id_utilisateur = acces.id_utilisateur 
                        WHERE acces.id_channel = ?");
$query->execute([$id_channel]);
$utilisateurs = $query->fetchAll();



$message = $message ?: ($_SESSION['message'] ?? '');
unset($_SESSION['message']);
