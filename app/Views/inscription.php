<?= $this->include('TypesMassages/Templates/header') ?>

<div class="container">
    <h2>Inscription</h2>
    <?php if(isset($validation)): ?>
        <div class="error-message">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>
    <form action="<?= base_url('inscription') ?>" method="post">
        <label for="nom_utilisateur">Nom d'utilisateur</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" value="<?= set_value('nom_utilisateur') ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= set_value('email') ?>" required>

        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>

        <label for="confirmpassword">Confirmer le mot de passe</label>
        <input type="password" id="confirmpassword" name="confirmpassword" required>

        <input type="hidden" name="role" value="3">

        <button type="submit" class="btn">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="<?= base_url('connexion') ?>">Connectez-vous ici</a></p>
</div>
<?= $this->include('TypesMassages/Templates/footer') ?>