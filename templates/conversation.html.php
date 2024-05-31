<div class="content-right-section">
    <div class="chat-container">
        <h2>
            <?= htmlspecialchars($title) ?>
        </h2>
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
    </div>
</div>