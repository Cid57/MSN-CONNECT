<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/conversation.css">
    <title>Conversation</title>
</head>

<body>
    <div class="content-right-section">
        <div class="chat-container">
            <h2><?= htmlspecialchars($title) ?></h2>

            <?php if (isset($_SESSION['error_message'])) : ?>
                <div class="error-message">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm1 17.25h-2v-2h2v2zm0-4h-2v-6h2v6z" />
                    </svg>
                    <div><?= htmlspecialchars($_SESSION['error_message']) ?></div>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <div class="message-container">
                <?php if (!empty($messages)) : ?>
                    <?php foreach ($messages as $msg) : ?>
                        <div class="message <?= $msg['id_utilisateur'] == $_SESSION['id_utilisateur'] ? 'sent' : 'received' ?>">
                            <p class="message-author"><?= htmlspecialchars($msg['prenom'] . ' ' . $msg['nom']) ?>:</p>
                            <p class="message-content"><?= nl2br(htmlspecialchars($msg['contenu'])) ?></p>
                            <p class="message-time"><?= date('d/m/Y H:i', strtotime($msg['date_heure_envoi'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Aucun message à afficher pour le moment.</p>
                <?php endif; ?>
            </div>
            <?php if ($channelExistant['est_groupe'] || $destinataire['est_actif_destinataire']) : ?>
                <form id="message-form" method="POST" class="message-form">
                    <div class="form-controls">
                        <textarea name="contenu" placeholder="Saisissez votre message ici..." rows="1" required></textarea>
                        <button type="submit" name="message_submit" id="messageSubmit">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="currentColor" d="M2 21l21-9L2 3v7l15 2-15 2z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            <?php else : ?>
                <div class="error-message">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm1 17.25h-2v-2h2v2zm0-4h-2v-6h2v6z" />
                    </svg>
                    <div>Vous ne pouvez pas envoyer de messages à cet utilisateur car il est désactivé.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>