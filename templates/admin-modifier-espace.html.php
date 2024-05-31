<!-- Banderole "gestion administrateur" -->

<div class="gestion-administrateur">
    <img src="assets/img/logo-admin.png" alt="icone logo admin">
    <h1>Modifier l'espace</h1>
    <div>
        <a href="/?page=administrateur"><img width="44" height="46" src="https://img.icons8.com/3d-fluency/94/left.png" alt="left" /></a>
        <a href="/"><img width="44" height="46" src="https://img.icons8.com/3d-fluency/94/delete-sign.png" alt="delete-sign" /></a>
    </div>
</div>

<!-- Fin de banderole -->

<div class="modifier-channel">
    <div class="modifier-section">
        <h2>Canaux</h2>
        <ul class="modifier-list">
            <?php foreach ($channels as $channel) : ?>
                <li>
                    <?= ($channel['nom_du_channel']) ?>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="id_channel" value="<?= ($channel['id_channel']) ?>">
                        <input type="submit" value="Modifier" class="btn-modifier">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>