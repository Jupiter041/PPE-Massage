<nav class="main-nav" style="position: fixed; left: 0; top: 60px; height: calc(100vh - 60px); width: 250px; background-color: #f8f9fa; box-shadow: 2px 0 5px rgba(0,0,0,0.1);">
    <div class="container">
        <ul class="nav-list" style="flex-direction: column; padding: 20px 0;">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('logs') ?>"><i class="fas fa-history"></i> Logs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/gestion/salles') ?>"><i class="fas fa-door-open"></i> Gestion des salles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/gestion/employes') ?>"><i class="fas fa-users"></i> Gestion des employés</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/empechements') ?>"><i class="fas fa-exclamation-circle"></i> Empêchements</a>
            </li>
        </ul>
    </div>
</nav>