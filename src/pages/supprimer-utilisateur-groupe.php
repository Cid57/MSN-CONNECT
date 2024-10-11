<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

// Vérifier si l'utilisateur a des droits d'administrateur, sinon rediriger vers la page d'accueil
if ($_SESSION['est_admin'] == 0) {
    header('Location: /');
    exit;
}

$message = ''; // Initialiser la variable pour les messages
// Récupérer l'ID du channel depuis l'URL, en s'assurant qu'il s'agit d'un entier valide
$id_channel = filter_input(INPUT_GET, 'id_channel', FILTER_SANITIZE_NUMBER_INT);

// Si la méthode de la requête est POST et que le bouton de soumission est cliqué
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['submit_button'])) {
    // Vérifier que le tableau des utilisateurs sélectionnés n'est pas vide et est bien un tableau
    if (!empty($_POST['utilisateur']) && is_array($_POST['utilisateur'])) {
        // Créer des placeholders pour les IDs des utilisateurs sélectionnés
        $ids_placeholders = implode(',', array_fill(0, count($_POST['utilisateur']), '?'));

        // Préparer la requête pour supprimer les utilisateurs sélectionnés du groupe (table 'acces')
        $query = $dbh->prepare("DELETE FROM acces WHERE id_channel = ? AND id_utilisateur IN ($ids_placeholders)");
        // Exécuter la requête en utilisant l'ID du channel et les IDs des utilisateurs sélectionnés
        $query->execute(array_merge([$id_channel], $_POST['utilisateur']));

        // Stocker un message de confirmation dans la session et rediriger vers la même page
        $_SESSION['message'] = "Les utilisateurs sélectionnés ont été supprimés du groupe avec succès.";
        header("Location: /?page=supprimer-utilisateur-groupe&id_channel=$id_channel");
        exit;
    } else {
        // Si aucun utilisateur n'a été sélectionné, afficher un message d'erreur
        $message = "Veuillez sélectionner au moins un utilisateur.";
    }
}

// Récupérer la liste des utilisateurs qui font partie du groupe
$query = $dbh->prepare("SELECT utilisateur.id_utilisateur, utilisateur.prenom, utilisateur.nom, utilisateur.email 
                        FROM utilisateur 
                        JOIN acces ON utilisateur.id_utilisateur = acces.id_utilisateur 
                        WHERE acces.id_channel = ?");
$query->execute([$id_channel]); // Exécuter la requête avec l'ID du channel
$utilisateurs = $query->fetchAll(); // Récupérer tous les utilisateurs associés à ce channel

// Récupérer le message de confirmation ou d'erreur s'il existe
$message = $message ?: ($_SESSION['message'] ?? '');
// Supprimer le message de la session après l'avoir récupéré pour qu'il ne soit affiché qu'une seule fois
unset($_SESSION['message']);
