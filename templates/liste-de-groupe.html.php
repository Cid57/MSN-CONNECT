<!-- Banderole "liste de contact" -->
<div class="gestion-administrateur">
    <img src="assets/img/logo-admin.png" alt="icone logo admin">
    <h1>Liste des groupes</h1>
    <div class="actions">
        <a href="/?page=parametres"><img width="44" height="46" src="https://img.icons8.com/3d-fluency/94/left.png" alt="left"></a>
        <a href="/"><img width="44" height="46" src="https://img.icons8.com/3d-fluency/94/delete-sign.png" alt="delete-sign"></a>
    </div>
</div>
<!-- Fin de banderole -->

<div class="container-contact">
    <div class="recherche-barre">
        <input type="text" id="recherche-groupe" placeholder="Rechercher un groupe...">
        <button type="button" id="recherche-button">Rechercher</button>
    </div>
    <ul class="contact-list">
        <?php if (!empty($channels)) : ?>
            <?php foreach ($channels as $channel) : ?>
                <li>
                    <div class="contact-details">
                        <strong><?= htmlspecialchars($channel['nom_du_channel'], ENT_QUOTES, 'UTF-8') ?></strong>
                    </div>
                    <div class="contact-actions">
                        <!-- Doit rediriger vers un script php (dans le dossier script) qui vérifie si la conversation existe déjà et si ce n'est pas le cas la créer et donner les droits, puis rediriger vers la discussion en question -->
                        <a href="/script.php?script=creation-channel&utilisateur=<?= htmlspecialchars($channel['id_channel'], ENT_QUOTES, 'UTF-8') ?>">Ouvrir le groupe</a>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else : ?>
            <li>Aucun groupe trouvé.</li>
        <?php endif; ?>
    </ul>
</div>
