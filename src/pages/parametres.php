<?php

if (empty($_SESSION['id_utilisateur'])) {
    header('Location: /?page=connexion');
    exit;
}

$idUtilisateur = $_SESSION['id_utilisateur'];

if ($idUtilisateur) {
    $query = $dbh->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
    $query->execute(['id_utilisateur' => $idUtilisateur]);
    $utilisateur = $query->fetch();

    $nomUtilisateur = $utilisateur['nom'];
    $prenomUtilisateur = $utilisateur['prenom'];
    $emailUtilisateur = $utilisateur['email'];
}
