<?php
session_start();
if (!isset($_SESSION['id_utilisateur'])) {
    echo json_encode([]);
    exit;
}

$idUtilisateur = $_SESSION['id_utilisateur'];
$idChannel = isset($_GET['id_channel']) ? (int)$_GET['id_channel'] : null;

if (!$idChannel) {
    echo json_encode([]);
    exit;
}

try {
    $dbh = new PDO('mysql:host=localhost;dbname=msn-connect', 'root', ' ');
} catch (PDOException $e) {
    echo json_encode([]);
    exit;
}

$lastCheck = isset($_SESSION['last_check']) ? $_SESSION['last_check'] : time();

while (true) {
    clearstatcache();
    $current_time = time();
    $query = $dbh->prepare(
        "SELECT message.*, utilisateur.prenom, utilisateur.nom 
        FROM message
        INNER JOIN utilisateur ON message.id_utilisateur = utilisateur.id_utilisateur
        WHERE message.id_channel = :id_channel AND UNIX_TIMESTAMP(message.date_heure_envoi) > :last_check
        ORDER BY date_heure_envoi"
    );
    $query->execute(['id_channel' => $idChannel, 'last_check' => $lastCheck]);
    $messages = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($messages)) {
        $_SESSION['last_check'] = $current_time;
        echo json_encode($messages);
        break;
    }
    usleep(500000);
}
