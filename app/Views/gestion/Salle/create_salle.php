<div class="container mt-4">
    <h2>Ajouter une salle</h2>
    
    <?php if(isset($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
                <?= esc($error) ?><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/gestion/salles/create') ?>" method="post">
        <div class="mb-3">
            <label for="nom_salle" class="form-label">Nom de la salle</label>
            <input type="text" class="form-control" id="nom_salle" name="nom_salle" required>
        </div>
        
        <div class="mb-3">
            <label for="disponibilite" class="form-label">Disponibilité</label>
            <select class="form-control" id="disponibilite" name="disponibilite" required>
                <option value="1">Disponible</option>
                <option value="0">Indisponible</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="<?= base_url('admin/gestion/salles') ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>