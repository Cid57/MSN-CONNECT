<?php

// Vérifier si l'utilisateur est connecté
if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

// Vérifier si l'utilisateur est un administrateur
if ($_SESSION['est_admin'] == 0) {
    header('Location: /');
    exit;
}

// Mettre à jour le nom du groupe si le formulaire est soumis
if (!empty($_POST['submit_button'])) {
    $id_channel = $_POST['id_channel'];
    $nom_du_channel = $_POST['nom_du_channel'];

    $query = $dbh->prepare("UPDATE channel SET nom_du_channel = :nom_du_channel WHERE id_channel = :id_channel AND est_groupe = 1 AND est_actif = 1");
    $query->execute([
        'nom_du_channel' => $nom_du_channel,
        'id_channel' => $id_channel
    ]);

    // Stocker le message de confirmation dans la session
    $_SESSION['message'] = "L'espace a été modifié avec succès.";
}

// Récupérer la liste des groupes actifs
$query = $dbh->query("SELECT id_channel, nom_du_channel FROM channel WHERE est_groupe = 1 AND est_actif = 1");
$channels = $query->fetchAll();

// Récupérer le message de confirmation de la session s'il existe
$message = $_SESSION['message'] ?? '';
// Supprimer le message après l'avoir récupéré
unset($_SESSION['message']);

