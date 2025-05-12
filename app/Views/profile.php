<div class="container">
    <h2>Profil de l'utilisateur</h2>
    
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if(session()->get('isLoggedIn')): ?>
        <div class="profile-info">
            <p><strong>Nom:</strong> <?= esc(session()->get('name')) ?></p>
            <p><strong>Email:</strong> <?= esc(session()->get('email')) ?></p>
            <p><strong>Rôle:</strong> <?= esc(session()->get('role')) ?></p>
        </div>

        <a href="<?= base_url('profile/edit') ?>" class="btn btn-edit">Modifier le profil</a>
    <?php else: ?>
        <p>Aucune information de profil disponible.</p>
    <?php endif; ?>
</div>