<?php
// Récupérer les informations de l'utilisateur
$idUtilisateur = $_SESSION['id_utilisateur'];

$query = $dbh->query("SELECT * FROM utilisateur 
                        INNER JOIN statut_utilisateur ON utilisateur.id_statut_utilisateur = statut_utilisateur.id_statut_utilisateur 
                        WHERE id_utilisateur = $idUtilisateur");
$utilisateur = $query->fetch();

$prenomUtilisateur = $utilisateur['prenom'];
$nomUtilisateur = $utilisateur['nom'];

$dateCreationUtilisateur = $utilisateur['date_de_creation'];
$statutUtilisateur = ['nom' => $utilisateur['nom_statut'], 'disponible' => $utilisateur['est_disponible']];

// Récupérer les discussions
$query = $dbh->prepare("SELECT channel.*, utilisateur.prenom AS prenom_destinataire, utilisateur.nom AS nom_destinataire FROM channel 
                        INNER JOIN acces AS mon_acces ON channel.id_channel = mon_acces.id_channel 
                        INNER JOIN acces AS destinataire_acces ON mon_acces.id_channel = destinataire_acces.id_channel
                        INNER JOIN utilisateur ON destinataire_acces.id_utilisateur = utilisateur.id_utilisateur  
                        WHERE mon_acces.id_utilisateur = :id_utilisateur AND destinataire_acces.id_utilisateur <> :id_utilisateur AND est_groupe = 0 AND channel.est_actif = 1 
                        ORDER BY date_heure_dernier_message DESC 
                        LIMIT 10");
$query->execute([
    'id_utilisateur' => $idUtilisateur,
]);
$discussions = $query->fetchAll();

// Récupérer les groupes
$query = $dbh->query("SELECT * FROM channel 
                        INNER JOIN acces ON channel.id_channel = acces.id_channel 
                        WHERE acces.id_utilisateur = $idUtilisateur AND est_groupe = 1 AND est_actif = 1 
                        ORDER BY date_heure_dernier_message DESC 
                        LIMIT 10");
$groupes = $query->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sedan+SC&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/mobile.css">

    <?php if (file_exists("assets/css/$page.css")) : ?>
        <link rel="stylesheet" href="assets/css/<?= $page ?>.css">
    <?php endif; ?>

    <script defer src="assets/js/main.js"></script>
    <?php if (file_exists("assets/js/$page.js")) : ?>
        <script defer src="assets/js/<?= $page ?>.js"></script>
    <?php endif; ?>

    <title>MSNConnect</title>
    <meta name="description" content="La renaissance de MSN.">

</head>

<body>
    <div class="container">
        <header>
            <nav>
                <div class="logo-container">
                    <img src="/assets/img/msn.png" alt="logo-msn">
                    <a href="/">
                        <h1>MSNConnect</h1>
                    </a>
                </div>

                <div class="menu-list">
                    <h4><?= "$prenomUtilisateur $nomUtilisateur" ?> </h4>
                    <a href="/?page=administrateur" class="btn"><img src="assets/img/reglages.png" alt="reglage-admin"></a>
                    <a href="/?page=parametres"><img src="/assets/img/utilisateur.png" alt="utilisateur" /></a>
                    <a href="scripts.php?script=deconnexion"><img src="/assets/img/se-deconnecter.png" alt="logo-deconnexion"></a>
                </div>
            </nav>
        </header>

        <main>
            <div class="sidebar-left">
                <div class="top-block">
                    <h4>Message privé</h4>

                    <!-- Bouton liste de contact -->
                    <div class="logo-personne">
                        <button class="recherche-personne">
                            <a href="/?page=liste-de-contact" class="btn">
                                <img src="assets/img/contacts.png" alt="">Liste des contacts</a>
                        </button>
                    </div>

                    <?php foreach ($discussions as $discussion) : ?>
                        <div class="message-prive-container">
                            <a href="/index.php?page=conversation&id_channel=<?= $discussion['id_channel'] ?>" class="message-prive-link"><?= htmlspecialchars($discussion['prenom_destinataire'] . ' ' . $discussion['nom_destinataire']) ?></a>
                            <!-- Lien de suppression de la conversation -->
                            <a href="/?page=delete-conversation&id_channel=<?= $discussion['id_channel'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette conversation ?');" class="delete-conversation-link">X</a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="bottom-block">
                    <h4>Espaces groupe</h4>

                    <!-- Bouton liste de groupe -->
                    <div class="logo-personne">
                        <button class="recherche-personne">
                            <a href="/?page=liste-de-groupe" class="btn">
                                <img src="assets/img/liste-de-groupe.png" alt="">Liste des groupes</a>
                        </button>
                    </div>

                    <?php foreach ($groupes as $groupe) : ?>
                        <div class="message-groupe-container">
                            <a href="/index.php?page=conversation&id_channel=<?= $groupe['id_channel'] ?>" class="message-groupe-link"><?= htmlspecialchars($groupe['nom_du_channel']) ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="couleur"></div>
            <div>
                <?php require  "../templates/$page.html.php"; ?>
            </div>
        </main>
    </div>
</body>

</html>