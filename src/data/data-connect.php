<?php
// Informations de connexion à la base de données
$host = 'localhost'; // Nom du serveur MySQL
$user = 'root'; // Nom d'utilisateur MySQL
$password = ''; // Mot de passe MySQL
$dbName = 'msn-connect'; // Nom de la base de données

try {
    // Connexion à la base de données avec PDO
    $dbh = new PDO(
        "mysql:host=$host; dbname=$dbName", // Chaîne de connexion PDO pour MySQL
        $user, // Nom d'utilisateur
        $password, // Mot de passe
        [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Mode de récupération par défaut des données (associatif)
        ]
    );
} catch (PDOException $e) {
    // En cas d'erreur lors de la connexion, affiche un message d'erreur
    echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
    die; // Arrête l'exécution du script
}
