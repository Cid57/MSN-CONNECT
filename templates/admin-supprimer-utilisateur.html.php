  <!-- banderole -->
  <div class="gestion-administrateur">
      <img src="assets/img/supprimer-user.png" alt="Icone supprimer un utilisateur" class="user-icon">
      <!-- <img src="assets/img/logo-admin.png" alt="icone logo admin"> -->
      <h1>Supprimer un utilisateur</h1>
      <div class="actions">
          <a href="/?page=administrateur"><img src="https://img.icons8.com/3d-fluency/94/left.png" alt="left"></a>
          <a href="/"><img src="https://img.icons8.com/3d-fluency/94/delete-sign.png" alt="delete-sign"></a>
      </div>
  </div>
  <!-- Fin banderole -->




  <div class="container-supprimer">

      <?php if ($message) : ?>
          <div class="message"> <?= ($message) ?></div>
      <?php endif; ?>

      <form method="post">
          <?php foreach ($utilisateurs as $utilisateur) : ?>
              <div class="user-checkbox">
                  <input type="checkbox" name="utilisateur[]" value="<?= $utilisateur['id_utilisateur'] ?>">
                  <p><?= $utilisateur['prenom'] . ' ' . $utilisateur['nom'] ?></p>
              </div>
          <?php endforeach; ?>
          <p class="warning">Attention cette action est irréversible.</p>
          <input type="submit" name="submit_button" value="Supprimer les utilisateurs sélectionnés" class="submit-button">
      </form>

  </div>