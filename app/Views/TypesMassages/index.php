<h2>Liste des Types de Massages</h2>
<?php if(session()->get('role') === 1): ?>
    <div class="admin-actions">
        <a href="<?= base_url('TypesMassages/create') ?>" class="btn btn-create">Ajouter un type de massage</a>
    </div>
<?php endif; ?>
<ul>
    <?php foreach ($typesMassages as $typeMassage): ?>
        <li>
            <?php if (isset($typeMassage->image) && !empty($typeMassage->image)): ?>
                <img src="<?= base_url('assets/images/' . $typeMassage->image) ?>" alt="<?= esc($typeMassage->nom_type) ?>" class="massage-image">
            <?php endif; ?>
            <h3><?= esc($typeMassage->nom_type) ?></h3>
            <p class="massage-price"><?= esc($typeMassage->prix) ?> €</p>
            <div class="massage-description">
                <p><?= esc($typeMassage->description) ?></p>
            </div>
            <div class="massage-type-actions">
                <a href="<?= base_url('Panier/ajouter/' . $typeMassage->type_id) ?>" class="btn-add-to-cart">Ajouter au panier</a>
                <?php if(session()->get('role') === 1): ?>
                    <a href="<?= base_url('TypesMassages/edit/' . $typeMassage->type_id) ?>" class="btn btn-edit">Modifier</a>
                    <a href="<?= base_url('TypesMassages/delete/' . $typeMassage->type_id) ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce type de massage ?');">Supprimer</a>
                <?php endif; ?>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
