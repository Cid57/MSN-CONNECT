<!-- Banderole "gestion administrateur" -->
<div class="gestion-administrateur">
    <img src="assets/img/reactiver-user.png" alt="Icone réactiver un utilisateur" class="user-icon">
    <h1>Réactiver un utilisateur</h1>
    <div class="actions">
        <a href="/?page=admin-ajouter-utilisateur"><img width="44" height="46" src="https://img.icons8.com/3d-fluency/94/left.png" alt="left"></a>
        <a href="/"><img width="44" height="46" src="https://img.icons8.com/3d-fluency/94/delete-sign.png" alt="delete-sign"></a>
    </div>
</div>
<!-- Fin banderole -->

<div class="container-reactiver">
    <?php if ($message) : ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="table-container">
        <?php foreach ($utilisateurs as $utilisateur) : ?>
            <label class="user-checkbox">
                <input type="checkbox" name="utilisateur[]" value="<?= $utilisateur['id_utilisateur'] ?>">
                <p><?= htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']) . ' (' . htmlspecialchars($utilisateur['email']) . ')' ?></p>
            </label>
        <?php endforeach; ?>
        <div class="sticky-button-container">
            <input type="submit" name="submit_button" value="Réactiver les utilisateurs sélectionnés" class="submit-button">
        </div>
    </form>
</div>
