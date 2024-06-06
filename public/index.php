<?php

session_start();

// Nettoie et récupère la variable 'page' des paramètres GET
$page = filter_var($_GET['page'] ?? 'accueil', FILTER_SANITIZE_SPECIAL_CHARS);

$chemin = "../src/pages/$page.php";

$pagesDeConnexion = ['connexion', 'mdp-reset'];
$layout = in_array($page, $pagesDeConnexion) ? 'layout-deconnecte' : 'layout-connecte';

// Vérifie si le fichier de la page existe
if(file_exists($chemin)){
    require '../src/data/data-connect.php';  // Inclut les données de connexion
    require $chemin;  // Charge le fichier de la page à afficher
    require "../templates/$layout.html.php"; // Charge le modèle de mise en page
} else {
    // Si le fichier de la page n'existe pas, renvoie une erreur 404
    header('HTTP/1.1 404 Not Found');
    require '../templates/404.html.php';  // Affiche la page d'erreur 404
    exit;
}
