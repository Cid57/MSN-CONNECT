<?php


// if (empty($_SESSION['id_utilisateur'])) {
//     header('Location: /?page=connexion');
//     exit;
// }


// $idUtilisateur = $_SESSION['id_utilisateur'];
// $idChannel = isset($_GET['id_channel']) ? (int)$_GET['id_channel'] : null;

// if (!$idChannel) {

//     header('Location: /');
//     exit;
// }


// $query = $dbh->prepare("SELECT * FROM acces WHERE id_channel = :id_channel AND id_utilisateur = :id_utilisateur");
// $query->execute(['id_channel' => $idChannel, 'id_utilisateur' => $idUtilisateur]);
// $acces = $query->fetch();

// if (!$acces) {

//     header('Location: /');
//     exit;
// }

// try {

//     $query = $dbh->prepare("DELETE FROM message WHERE id_channel = :id_channel");
//     $query->execute(['id_channel' => $idChannel]);


//     $query = $dbh->prepare("DELETE FROM acces WHERE id_channel = :id_channel");
//     $query->execute(['id_channel' => $idChannel]);


//     $query = $dbh->prepare("DELETE FROM channel WHERE id_channel = :id_channel");
//     $query->execute(['id_channel' => $idChannel]);


//     header('Location: /');
//     exit;
// } catch (Exception $e) {
//     echo "Erreur : " . $e->getMessage();
//     exit;
// }
