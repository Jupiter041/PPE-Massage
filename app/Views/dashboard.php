<?= $this->include('TypesMassages/Templates/header') ?>
<?= $this->include('TypesMassages/Templates/navbar') ?>

<div class="container">
    <h2>Tableau de bord</h2>
    
    <?php if(session()->getFlashdata('success')): ?>
        <div class="success-message">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-stats">
        <?php if(session()->get('role') === '1'): ?>
            <div class="dashboard-card">
                <h3>Administration</h3>
                <div class="admin-actions">
                    <a href="<?= base_url('TypesMassages/create') ?>" class="btn">Ajouter un massage</a>
                    <a href="<?= base_url('TypesMassages') ?>" class="btn">Gérer les massages</a>
                </div>
            </div>

            <div class="dashboard-card">
                <h3>Logs du système</h3>
                <div class="logs-container">
                    <?php 
                    $logModel = new \App\Models\LogModel();
                    $logs = $logModel->orderBy('date_log', 'DESC')->limit(10)->get();
                    
                    foreach($logs as $log): ?>
                        <div class="log-entry">
                            <p><strong>Table:</strong> <?= esc($log->table_name) ?></p>
                            <p><strong>Action:</strong> <?= esc($log->action) ?></p>
                            <p><strong>Description:</strong> <?= esc($log->description) ?></p>
                            <p><strong>Date:</strong> <?= $log->date_log->format('d/m/Y H:i:s') ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="dashboard-card">
            <h3>Mon Profil</h3>
            <div class="profile-info">
                <p><strong>Nom:</strong> <?= esc(session()->get('name')) ?></p>
                <p><strong>Email:</strong> <?= esc(session()->get('email')) ?></p>
                <p><strong>Rôle:</strong> 
                    <?php
                    switch(session()->get('role')) {
                        case '1':
                            echo 'Administrateur';
                            break;
                        case '2':
                            echo 'Masseur';
                            break;
                        case '3':
                            echo 'Client';
                            break;
                        default:
                            echo 'Utilisateur';
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.dashboard-card {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: var(--box-shadow);
}

.dashboard-card h3 {
    color: var(--secondary-color);
    margin-bottom: 15px;
    text-align: left;
}

.admin-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.profile-info p {
    margin-bottom: 10px;
    color: var(--text-color);
}

.profile-info strong {
    color: var(--secondary-color);
}

.logs-container {
    max-height: 400px;
    overflow-y: auto;
}

.log-entry {
    padding: 10px;
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 10px;
}

.log-entry:last-child {
    border-bottom: none;
}

.log-entry p {
    margin: 5px 0;
    color: var(--text-color);
}

@media (prefers-color-scheme: dark) {
    .dashboard-card {
        background-color: var(--nav-background);
    }
}
</style>

<?= $this->include('TypesMassages/Templates/footer') ?>
