<div class="password-reset-form">
    <div class="container">
        <h2>Réinitialisation du mot de passe</h2>

        <?php if (!empty($message)) : ?>
            <p class="<?= strpos($message, 'succès') !== false ? 'success_message' : 'error_message' ?>"><?= $message; ?></p>
        <?php endif; ?>

        <?php if (empty($message) || strpos($message, 'succès') === false) : ?>
            <form method="post">
                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>

                <div class="form-group">
                    <button type="submit" name="reset_password">Réinitialiser le mot de passe</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>