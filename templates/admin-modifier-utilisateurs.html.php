<!-- Banderole "gestion administrateur" -->
<div class="gestion-administrateur">
    <img src="assets/img/logo-admin.png" alt="icone logo admin">
    <h1>Modifier un utilisateur</h1>
    <div class="actions">
        <a href="/?page=administrateur"><img width="44" height="46" src="https://img.icons8.com/3d-fluency/94/left.png" alt="left"></a>
        <a href="/"><img width="44" height="46" src="https://img.icons8.com/3d-fluency/94/delete-sign.png" alt="delete-sign"></a>
    </div>
</div>
<!-- Fin de banderole -->

<div class="container-modifier">
    <table>
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Mail</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $utilisateur) : ?>
                <tr>
                    <td><?= htmlspecialchars($utilisateur['prenom']) ?></td>
                    <td><?= htmlspecialchars($utilisateur['nom']) ?></td>
                    <td><?= htmlspecialchars($utilisateur['email']) ?></td>
                    <td><a href="/?page=admin-modifier-utilisateur&id=<?= $utilisateur['id_utilisateur'] ?>"><button>Modifier</button></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>