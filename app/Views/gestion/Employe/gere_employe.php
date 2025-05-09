<div class="container mt-4">
    <h2>Gestion des Employés</h2>
    
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="<?= base_url('admin/gestion/employes/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un employé
        </a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($employes as $employe): ?>
            <tr>
                <td><?= $employe->employe_id ?></td>
                <td><?= esc($employe->compte->nom_utilisateur) ?></td>
                <td><?= esc($employe->compte->email) ?></td>
                <td>
                    <?php if($employe->type_employe == 'masseur'): ?>
                        <span class="badge bg-primary">Masseur</span>
                    <?php else: ?>
                        <span class="badge bg-warning">Administrateur</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url('admin/gestion/employes/edit/'.$employe->employe_id) ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="<?= base_url('admin/gestion/employes/delete/'.$employe->employe_id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')">
                        <i class="fas fa-trash"></i> Supprimer
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>