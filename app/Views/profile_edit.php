<div class="container">
    <h2>Modifier le profil</h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if(isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif; ?>

    <?= form_open('profile/update') ?>
        <div class="form-group">
            <label for="nom_utilisateur">Nom</label>
            <input type="text" name="nom_utilisateur" id="nom_utilisateur" class="form-control" required value="<?= esc($user['nom_utilisateur']) ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required value="<?= esc($user['email']) ?>">
        </div>
        <div class="form-group">
            <label for="mot_de_passe">Nouveau mot de passe (laissez vide pour ne pas changer)</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control">
        </div>
        <div class="form-group">
            <label for="confirmpassword">Confirmer le nouveau mot de passe</label>
            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
    <?= form_close() ?>

    <a href="<?= base_url('profile') ?>" class="btn btn-secondary">Retour au profil</a>
</div>
