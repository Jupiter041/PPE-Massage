<body>
<nav class="main-nav">
    <ul class="nav-list">
        <?php var_dump(base_url()); ?>
        <li class="nav-item"><a href="<?= base_url('/') ?>" class="nav-link">Accueil</a></li>
        <?php if (session()->get('isLoggedIn')): ?>
            <?php if (session()->get('role') == '1'): ?>
                <li class="nav-item"><a href="<?= base_url('/dashboard') ?>" class="nav-link">Tableau de bord</a></li>
            <?php endif; ?>
            <li class="nav-item"><a href="<?= base_url('/deconnexion') ?>" class="nav-link">Déconnexion</a></li>
            <li class="nav-item profile-item">
                <a href="<?= base_url('/panier') ?>" class="profile-link">
                    <div class="profile-wrapper">
                        <img src="<?= base_url('assets/images/panier-icon.svg') ?>" alt="Panier" class="profile-icon">
                        <span class="profile-text">Panier</span>
                    </div>
                </a>
            </li>
            <li class="nav-item profile-item">
                <a href="<?= base_url('/profile') ?>" class="profile-link">
                    <div class="profile-wrapper">
                        <img src="<?= base_url('assets/images/profile-icon.png') ?>" alt="Profile" class="profile-icon">
                        <span class="profile-text">Profil</span>
                    </div>
                </a>
            </li>
        <?php else: ?>
            <li class="nav-item"><a href="<?= base_url('/connexion') ?>" class="nav-link">Connexion</a></li>
            <li class="nav-item"><a href="<?= base_url('/inscription') ?>" class="nav-link">Inscription</a></li>
        <?php endif; ?>
    </ul>
</nav>
