<?php
// session_start();
// header('Content-Type: application/json');

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (empty($_SESSION['id_utilisateur'])) {
//         echo json_encode(['status' => 'error', 'message' => 'Utilisateur non connecté']);
//         exit;
//     }

//     $idUtilisateur = $_SESSION['id_utilisateur'];
//     $idChannel = $_POST['id_channel'];
//     $contenu = htmlspecialchars($_POST['contenu'] ?? '');

//     if (empty($contenu)) {
//         echo json_encode(['status' => 'error', 'message' => 'Message vide']);
//         exit;
//     }

//     try {
//         $dbh = new PDO('mysql:host=localhost;dbname=msn-connect', 'root', '');
//     } catch (PDOException $e) {
//         echo json_encode(['status' => 'error', 'message' => 'Erreur de connexion à la base de données']);
//         exit;
//     }

//     $query = $dbh->prepare(
//         "INSERT INTO message (date_heure_envoi, contenu, id_channel, id_utilisateur)
//         VALUES (NOW(), :contenu, :id_channel, :id_utilisateur)"
//     );
//     $query->execute([
//         'contenu' => $contenu,
//         'id_channel' => $idChannel,
//         'id_utilisateur' => $idUtilisateur
//     ]);

//     $query = $dbh->prepare("UPDATE channel SET date_heure_dernier_message = NOW() WHERE id_channel = :id_channel");
//     $query->execute(['id_channel' => $idChannel]);

//     echo json_encode(['status' => 'success']);
// } else {
//     echo json_encode(['status' => 'error', 'message' => 'Requête invalide']);
// }
