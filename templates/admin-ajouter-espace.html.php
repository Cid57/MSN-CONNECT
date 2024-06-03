<!-- Banniere Gestion administrateur -->
<div class="banniere-gestion-administrateur">
    <img src="assets/img/logo-admin.png" alt="icone logo admin">
    <h1> Gestion administrateur </h1>
    <div>
        <a href="/?page=administrateur"><img src="https://img.icons8.com/3d-fluency/94/left.png" alt="left" /></a>
        <a href="/"><img src="https://img.icons8.com/3d-fluency/94/delete-sign.png" alt="delete-sign" /></a>
    </div>
</div>
<!-- --------------------------------------- -->

<div class="conteneur-ajout-groupe">
    <div class="en-tete">
        <img src="assets/img/bulle-bleu.png" alt="Icone ajouter espace">
        <h2>Ajouter un groupe</h2>
    </div>

    <!-- Formulaire -->
    <form method="post">
        <div>
            <label for="ajout-groupe">Nom de l'espace</label><br>
            <input type="text" id="ajout-groupe" name="ajout_groupe" placeholder="Entrez le nom du groupe">
            <!-- Affiche les message d'erreurs sous l'input de l'espace -->
            <?php if (!empty($errors['groupe'])) : ?>
                <p><?= $errors['groupe'] ?></p>
            <?php endif; ?>
        </div>
        <br>
        <input type="submit" id="espaceBouton" name="groupe_bouton" value="Ajouter le groupe">
    </form>
    <!-- Fin du formulaire -->
</div>