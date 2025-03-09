<h2>Modifier un Type de Massage</h2>

<form action="<?= site_url('TypesMassages/update/' . $typeMassage['type_id']) ?>" method="post">
    <?= csrf_field() ?>
    <label for="nom_type">Nom du Type de Massage</label>
    <input type="text" name="nom_type" value="<?= esc($typeMassage['nom_type']) ?>"><br>

    <label for="description">Description</label>
    <textarea name="description"><?= esc($typeMassage['description']) ?></textarea><br>

    <label for="prix">Prix</label>
    <input type="text" name="prix" value="<?= esc($typeMassage['prix']) ?>"><br>

    <input type="submit" value="Modifier" class="btn btn-edit">
</form>
