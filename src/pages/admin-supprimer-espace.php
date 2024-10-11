<?php

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

// Vérifier si l'utilisateur a des droits d'administrateur, sinon le rediriger vers la page d'accueil
if ($_SESSION['est_admin'] == 0) {
    header('Location: /');
    exit;
}

// Vérifier si le formulaire de soumission a été envoyé
if (!empty($_POST['submit_button'])) {
    // Créer une liste de placeholders pour les IDs sélectionnés dans le formulaire
    $ids_placeholders = implode(',', array_fill(0, count($_POST['espace']), '?'));

    // Préparer la requête SQL pour désactiver les channels sélectionnés
    $query = $dbh->prepare("UPDATE channel SET est_actif = 0 WHERE id_channel IN ($ids_placeholders)");
    // Exécuter la requête en utilisant les IDs des espaces sélectionnés
    $query->execute($_POST['espace']);

    // Stocker un message de confirmation dans la session pour l'afficher après la suppression
    $_SESSION['message'] = "Les espaces sélectionnés ont été supprimés avec succès.";
} else {
    // Si aucun espace n'a été sélectionné, afficher un message d'erreur
    $message = "Aucun espace sélectionné pour la suppression.";
}

// Récupérer la liste des groupes actifs pour les afficher dans l'interface
$query = $dbh->query("SELECT id_channel, nom_du_channel FROM channel WHERE est_groupe = 1 AND est_actif = 1");
$espaces = $query->fetchAll();

// Récupérer le message de confirmation stocké dans la session, s'il existe
$message = $_SESSION['message'] ?? '';
// Supprimer le message de la session après l'avoir récupéré pour éviter qu'il s'affiche à nouveau
unset($_SESSION['message']);
