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
$id_channel = $_GET['id_channel'] ?? null;



if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['submit_button'])) {
    if (!empty($_POST['utilisateur']) && is_array($_POST['utilisateur'])) {
        $id_channel = $_POST['id_channel'];
        $ids_placeholders = implode(',', array_fill(0, count($_POST['utilisateur']), '?'));

        $query = $dbh->prepare("INSERT INTO acces (id_utilisateur, id_channel, est_gestionnaire) VALUES (?, ?, 0)");
        foreach ($_POST['utilisateur'] as $id_utilisateur) {
            $query->execute([$id_utilisateur, $id_channel]);
        }

        $_SESSION['message'] = "Les utilisateurs sélectionnés ont été ajoutés avec succès au groupe.";
        header("Location: /?page=ajout-utilisateur-groupe&id_channel=$id_channel");
        exit;
    } else {
        $message = "Veuillez sélectionner au moins un utilisateur.";
    }
}

// Récupérer la liste des utilisateurs qui ne sont pas encore dans le groupe
$query = $dbh->prepare("
    SELECT u.id_utilisateur, u.prenom, u.nom, u.email 
    FROM utilisateur u 
    WHERE u.est_actif = 1
    AND u.id_utilisateur NOT IN (
        SELECT a.id_utilisateur 
        FROM acces a 
        WHERE a.id_channel = ?
    )
");
$query->execute([$id_channel]);
$utilisateurs = $query->fetchAll();

$message = $message ?: ($_SESSION['message'] ?? '');
unset($_SESSION['message']);
