<?php

if (!empty($_SESSION['id_utilisateur'])) {
    header('Location: /');
    exit;
}

// Gestion de la connexion
if (isset($_POST['connexion-submit'])) {
    if (!empty($_POST['email-connexion']) && !empty($_POST['mdp-connexion'])) {
        $emailConnexion = $_POST['email-connexion'];
        $mdpConnexion = $_POST['mdp-connexion'];

        $errors = [];


        if (!filter_var($emailConnexion, FILTER_VALIDATE_EMAIL)) {
            $errors['email-connexion'] = 'Veuillez entrer une adresse email valide !';
        }
        if (empty($errors)) {
            $query = $dbh->prepare("SELECT * FROM utilisateur WHERE email = :email");
            $query->execute(['email' => $emailConnexion]);
            $utilisateur = $query->fetch();

            if ($utilisateur && password_verify($mdpConnexion, $utilisateur['mot_de_passe']) && $utilisateur['est_actif']) {
                $_SESSION['id_utilisateur'] = $utilisateur['id_utilisateur']; // Id de l'utilisateur.
                $_SESSION['est_admin'] = $utilisateur['est_admin']; // Si l'utilisateur est admin (1 admin, 0 non admin)
                header("Location: /");
                exit;
            } else {
                $errors['login_error'] = "Adresse email ou mot de passe incorrect.";
            }
        }
    } else {
        $errors['login_error'] = "Veuillez remplir tout les champs";
    }
}
