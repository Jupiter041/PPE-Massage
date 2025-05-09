<div class="container mt-4">
    <h2>Gestion des Salles</h2>
    
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="<?= base_url('admin/gestion/salles/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une salle
        </a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Disponibilité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($salles as $salle): ?>
            <tr>
                <td><?= $salle['salle_id'] ?></td>
                <td><?= esc($salle['nom_salle']) ?></td>
                <td>
                    <?php if($salle['disponibilite'] == 1): ?>
                        <span class="badge bg-success">Disponible</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Indisponible</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url('admin/gestion/salles/edit/'.$salle['salle_id']) ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="<?= base_url('admin/gestion/salles/delete/'.$salle['salle_id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette salle ?')">
                        <i class="fas fa-trash"></i> Supprimer
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>