<?= $this->include('TypesMassages/Templates/header') ?>

<div class="container">
    <h2>Connexion</h2>
    
    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>

    <?php if(isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif; ?>

    <?= form_open('/connexion') ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required value="<?= old('email') ?>">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
    <?= form_close() ?>

    <p>Pas encore de compte ? <a href="<?= base_url('inscription') ?>">S'inscrire</a></p>
</div>

<?= $this->include('TypesMassages/Templates/footer') ?>
