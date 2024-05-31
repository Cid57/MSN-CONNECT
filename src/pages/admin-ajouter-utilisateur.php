<?php

if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

if ($_SESSION['est_admin'] == 0) {
    header('Location: /');
    exit;
}

$success = '';

if (isset($_POST['inscription_admin_bouton'])) {

    $errors = [];

    if (!empty($_POST['inscription_prenom'])) {
        $prenom = $_POST['inscription_prenom'];
    } else {
        $errors['prenom'] = 'Le champ \'prenom\' est obligatoire.';
    }

    if (!empty($_POST['inscription_nom'])) {
        $nom = $_POST['inscription_nom'];
    } else {
        $errors['nom'] = 'Le champ \'nom\' est obligatoire.';
    }

    if (!empty($_POST['inscription_email'])) {
        $email = $_POST['inscription_email'];
    } else {
        $errors['email'] = 'Le champ \'email\' est obligatoire.';
    }

    if (empty($errors)) {
        $query = $dbh->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $query->execute(['email' => $email]);
        $utilisateur = $query->fetch();

        if ($utilisateur) {
            if ($utilisateur['est_actif'] == 0) {
                $query = $dbh->prepare("UPDATE utilisateur SET prenom = :prenom, nom = :nom, est_admin = :est_admin, est_actif = 1 WHERE email = :email");
                $query->execute([
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'est_admin' => isset($_POST['inscription_admin']) ? 1 : 0,
                    'email' => $email
                ]);
                $success = 'L\'utilisateur a été réactivé avec succès.';
            } else {
                $errors['email'] = 'Un utilisateur avec cet email existe déjà.';
            }
        } else {
            $query = $dbh->prepare("INSERT INTO utilisateur (prenom, nom, email, date_de_creation, est_admin, est_actif) VALUES (:prenom, :nom, :email, NOW(), :est_admin, 1)");
            $query->execute([
                'prenom' => $prenom,
                'nom' => $nom,
                'email' => $email,
                'est_admin' => isset($_POST['inscription_admin']) ? 1 : 0
            ]);
            $success = 'L\'utilisateur a été ajouté avec succès.';
        }
    }
}
