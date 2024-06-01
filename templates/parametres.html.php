<!-- Banderole "gestion administrateur" -->
<div class="gestion-administrateur">
    <img src="assets/img/logo-admin.png" alt="icone logo admin">
    <h1>Paramètres du profil</h1>
    <div class="actions">
        <a href="/"><img src="https://img.icons8.com/3d-fluency/94/delete-sign.png" alt="delete-sign"></a>
    </div>
</div>
<!-- Fin banderole -->

<div class="container-profile">
    <div class="content-block">
        <div class="content">
            <p><strong>NOM : </strong><?= htmlspecialchars($nomUtilisateur) ?></p>
            <p><strong>PRENOM : </strong><?= htmlspecialchars($prenomUtilisateur) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($emailUtilisateur) ?></p>
            <p><strong>Mot de passe : </strong>*******</p>
            <form method="post" enctype="multipart/form-data">
                <label for="avatar">Modifier Avatar :</label>
                <input type="file" name="avatar" id="avatar" accept="image/*">
                <?php if (!empty($utilisateur['avatar'])) : ?>
                    <div class="avatar">
                        <img src="uploads/<?= htmlspecialchars($utilisateur['avatar']) ?>" alt="Avatar de l'utilisateur">
                    </div>
                <?php endif; ?>
                <button type="submit" name="modifier_avatar">Enregistrer l'avatar</button>
            </form>
        </div>
    </div>

    <div class="form-block">
        <div class="container-modifier-mdp">
            <?php if (isset($message)) : ?>
                <div class="message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="post">
                <h2>Changer de mot de passe</h2>
                <br>
                <label for="ancien_mdp">Ancien mot de passe :</label>
                <div class="group">
                    <input type="password" name="ancien_mdp" id="ancien_mdp" required>
                    <div class="mdp-icon">
                        <i data-feather="eye" class="eye"></i>
                        <i data-feather="eye-off" class="eye-off" style="display: none;"></i>
                    </div>
                </div>

                <label for="nouveau_mdp">Nouveau mot de passe :</label>
                <div class="group">
                    <input type="password" name="nouveau_mdp" id="nouveau_mdp" required>
                    <div class="mdp-icon">
                        <i data-feather="eye" class="eye"></i>
                        <i data-feather="eye-off" class="eye-off" style="display: none;"></i>
                    </div>
                </div>

                <label for="confirmer_mdp">Confirmer le nouveau mot de passe :</label>
                <div class="group">
                    <input type="password" name="confirmer_mdp" id="confirmer_mdp" required>
                    <div class="mdp-icon">
                        <i data-feather="eye" class="eye"></i>
                        <i data-feather="eye-off" class="eye-off" style="display: none;"></i>
                    </div>
                </div>

                <button type="submit" name="modifier_mdp">Modifier le mot de passe</button>
            </form>
        </div>
    </div>
</div>

<script src="https://unpkg.com/feather-icons"></script>