<div class="container mt-4">
    <h2>Modifier l'employé</h2>
    
    <?php if(isset($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
                <?= esc($error) ?><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/gestion/employes/update/'.$employe->employe_id) ?>" method="post">
        <div class="mb-3">
            <label for="nom_utilisateur" class="form-label">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="nom_utilisateur" name="nom_utilisateur" value="<?= esc($employe->compte->nom_utilisateur) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= esc($employe->compte->email) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Nouveau mot de passe (laisser vide pour ne pas modifier)</label>
            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
        </div>
        
        <div class="mb-3">
            <label for="type_employe" class="form-label">Type d'employé</label>
            <select class="form-control" id="type_employe" name="type_employe" required>
                <option value="masseur" <?= $employe->type_employe == 'masseur' ? 'selected' : '' ?>>Masseur</option>
                <option value="admin" <?= $employe->type_employe == 'admin' ? 'selected' : '' ?>>Administrateur</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="<?= base_url('admin/gestion/employes') ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>