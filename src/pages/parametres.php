<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

$messageAvatar = '';
$messageMdp = '';

if (isset($_POST['modifier_mdp'])) {
    $ancienMdp = $_POST['ancien_mdp'];
    $nouveauMdp = $_POST['nouveau_mdp'];
    $confirmerMdp = $_POST['confirmer_mdp'];

    if (password_verify($ancienMdp, $utilisateur['mot_de_passe'])) {
        if ($nouveauMdp === $confirmerMdp) {
            $nouveauMdpHash = password_hash($nouveauMdp, PASSWORD_DEFAULT);
            $updateQuery = $dbh->prepare("UPDATE utilisateur SET mot_de_passe = :nouveau_mdp WHERE id_utilisateur = :id_utilisateur");
            $updateQuery->execute([
                'nouveau_mdp' => $nouveauMdpHash,
                'id_utilisateur' => $idUtilisateur
            ]);
            $messageMdp = "Mot de passe modifié avec succès.";
        } else {
            $messageMdp = "Les nouveaux mots de passe ne correspondent pas.";
        }
    } else {
        $messageMdp = "L'ancien mot de passe est incorrect.";
    }
}

if (isset($_POST['modifier_avatar']) && isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['avatar']['tmp_name'];
    $fileName = $_FILES['avatar']['name'];
    $fileSize = $_FILES['avatar']['size'];
    $fileType = $_FILES['avatar']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $uploadFileDir = './uploads/';
        $dest_path = $uploadFileDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $updateQuery = $dbh->prepare("UPDATE utilisateur SET avatar = :avatar WHERE id_utilisateur = :id_utilisateur");
            $updateQuery->execute([
                'avatar' => $fileName,
                'id_utilisateur' => $idUtilisateur
            ]);
            $messageAvatar = "Avatar modifié avec succès.";
        } else {
            $messageAvatar = "Une erreur est survenue lors du téléchargement de l'avatar.";
        }
    } else {
        $messageAvatar = "Seuls les fichiers avec les extensions suivantes sont autorisés : " . implode(', ', $allowedfileExtensions);
    }
}
