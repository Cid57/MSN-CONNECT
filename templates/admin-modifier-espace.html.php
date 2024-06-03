<!-- Banderole "gestion administrateur" -->
<div class="gestion-administrateur">
    <img src="assets/img/logo-admin.png" alt="icone logo admin">
    <h1>Modifier les groupes</h1>
    <div class="actions">
        <a href="/?page=administrateur"><img src="https://img.icons8.com/3d-fluency/94/left.png" alt="fleche-retour"></a>
        <a href="/"><img src="https://img.icons8.com/3d-fluency/94/delete-sign.png" alt="croix"></a>
    </div>
</div>
<!-- Fin de banderole -->

<div class="modifier-channel">
    <div class="modifier-section">
        <h2>Groupes</h2>
        <ul class="modifier-list">
            <?php foreach ($channels as $channel) : ?>
                <li>
                    <form method="post" action="/?page=admin-modifier-espace">
                        <input type="hidden" name="id_channel" value="<?= htmlspecialchars($channel['id_channel']) ?>">
                        <input type="text" name="nom_du_channel" value="<?= htmlspecialchars($channel['nom_du_channel']) ?>">
                        <input type="submit" name="submit_button" value="Modifier" class="btn-modifier">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>