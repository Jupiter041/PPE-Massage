<div class="container mt-4">
    <h2>Modifier la salle</h2>
    
    <?php if(isset($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
                <?= esc($error) ?><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/gestion/salles/update/'.$salle['salle_id']) ?>" method="post">
        <div class="mb-3">
            <label for="nom_salle" class="form-label">Nom de la salle</label>
            <input type="text" class="form-control" id="nom_salle" name="nom_salle" value="<?= esc($salle['nom_salle']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="disponibilite" class="form-label">Disponibilité</label>
            <select class="form-control" id="disponibilite" name="disponibilite" required>
                <option value="1" <?= $salle['disponibilite'] == 1 ? 'selected' : '' ?>>Disponible</option>
                <option value="0" <?= $salle['disponibilite'] == 0 ? 'selected' : '' ?>>Indisponible</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="<?= base_url('admin/gestion/salles') ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>