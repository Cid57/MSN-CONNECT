    <div class="inscription">
        <nav>
            <div class="vp-logo">
                <img src="assets\img\icon20-removebg-preview.png" width="auto" height="80px" alt="logo">
            </div>
        </nav>

        <main>
            <div class="login-wrap">
                <div class="login-html">

                    <label for="tab-1" class="tab">Connexion</label>

                    <!-- <input id="tab-2" type="radio" name="tab" class="sign-up">
                    <label for="tab-2" class="tab">Inscription</label> -->

                    <div class="login-form">
                        <!-- Formulaire de connexion -->
                        <form method="POST">
                            <div class="sign-in-htm">
                                <div class="group">
                                    <label class="label">Email</label>
                                    <input type="email" class="input" name="email-connexion" value="<?= $_POST['email-connexion'] ?? '' ?>">
                                    <?php if (!empty($errors['email-connexion'])) : ?>
                                        <p class="message-erreur"><?= htmlspecialchars($errors['email-connexion']) ?></p>
                                    <?php endif ?>
                                </div>
                                <br>
                                <div class="group">
                                    <label for="pass" class="label">Mot de passe</label>
                                    <input type="password" id="mdp1" class="input mdp-input" name="mdp-connexion">
                                    <div class="mdp-icon">
                                        <i data-feather="eye" class="eye"></i>
                                        <i data-feather="eye-off" class="eye-off" style="display: none;"></i>
                                    </div>
                                    <br>
                                    <?php if (!empty($errors['mdp-connexion'])) : ?>
                                        <p class="message-erreur"><?= htmlspecialchars($errors['mdp-connexion']) ?></p>
                                    <?php endif ?>
                                </div>
                                <!-- Affichage de l'erreur de connexion si elle existe -->
                                <?php if (!empty($errors['login_error'])) : ?>
                                    <p class="message-erreur"><?= htmlspecialchars($errors['login_error']) ?></p>
                                <?php endif ?>
                                <div class="group">
                                    <button class="button" type="submit" name="connexion-submit">Se connecter</button>
                                </div>
                                <div class="hr"></div>
                                <div class="foot-lnk">
                                    <a href="/?page=mdp-reset">Mot de passe oublié ?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>