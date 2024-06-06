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
                    <form method="post" action="/?page=admin-modifier-espace" style="display:inline;">
                        <input type="hidden" name="id_channel" value="<?= htmlspecialchars($channel['id_channel']) ?>">
                        <input type="text" name="nom_du_channel" value="<?= htmlspecialchars($channel['nom_du_channel']) ?>">
                        <input type="submit" name="submit_button" value="Modifier" class="btn-modifier">
                    </form>
                    <form method="get" action="/" style="display:inline;">
                        <input type="hidden" name="page" value="ajout-utilisateur-groupe">
                        <input type="hidden" name="id_channel" value="<?= htmlspecialchars($channel['id_channel']) ?>">
                        <input type="submit" value="Ajouter utilisateurs" class="btn-ajouter">
                    </form>
                    <form method="get" action="/" style="display:inline;">
                        <input type="hidden" name="page" value="supprimer-utilisateur-groupe">
                        <input type="hidden" name="id_channel" value="<?= htmlspecialchars($channel['id_channel']) ?>">
                        <input type="submit" value="Supprimer utilisateurs" class="btn-supprimer">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

