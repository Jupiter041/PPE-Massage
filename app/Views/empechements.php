<div class="container mt-4">
    <h2>Liste des empêchements</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Motif</th>
                <th>Date de création</th>
                <th>Heure de réservation</th>
                <th>Durée</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($empechements as $empechement): ?>
                <tr>
                    <td><?= $empechement['nom'] ?></td>
                    <td><?= $empechement['motif'] ?></td>
                    <td><?= $empechement['created_at'] ?></td>
                    <td><?= $empechement['heure_reservation'] ?></td>
                    <td><?= $empechement['duree'] ?></td>
                    <td>
                        <a href="<?= base_url('/empechement/delete/' . $empechement['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet empêchement ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
