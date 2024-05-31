<?php


if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

if ($_SESSION['est_admin'] == 0) {
    header('Location: /');
    exit;
}

// On vérifie si l'utilisateur accède à la page en passant par le bouton 'Envoyer' du formulaire
if (isset($_POST['groupe_bouton'])) {

    $errors = [];

    if (!empty($_POST['ajout_groupe'])) {

        $groupe = $_POST['ajout_groupe'];
    } else {

        $errors['groupe'] = 'Le champ groupe est obligatoire.';
    }

    // On vérifie s'il n'y a aucune erreur en vérifiant si le tableau de la variable errors est vide
    if (empty($errors)) {
        // On insère dans la base de données
        $query = $dbh->prepare("INSERT INTO channel (nom_du_channel, date_heure_dernier_message, est_groupe) VALUES (:nom_du_channel, NOW(), 1)");
        $query->execute([
            'nom_du_channel' => $groupe,
        ]);

        // On redirige vers l'accueil 
        header('Location: /');
        die;
    }
}
