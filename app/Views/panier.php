<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>
    <h2><?= $title ?></h2>

    <?php if (session()->has('success')): ?>
        <div class="alert-panier alert-success-panier">
            <?= session()->get('success') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($panier)): ?>
        <p>Votre panier est vide.</p>
        <a href="<?= base_url('TypesMassages') ?>" class="btn">Continuer mes achats</a>
    <?php else: ?>
        <table class="table-panier">
            <thead>
                <tr>
                    <th>Type de Massage</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($panier as $item): ?>
                    <tr>
                        <td><?= esc($item->typeMassage->nom) ?></td>
                        <td><?= number_format($item->typeMassage->prix, 2) ?> €</td>
                        <td>
                            <form action="<?= base_url('panier/updateQuantite') ?>" method="post" class="quantity-form-panier">
                                <input type="hidden" name="type_massage_id" value="<?= $item->type_massage_id ?>">
                                <input type="number" name="quantite" value="<?= $item->quantite ?>" min="1" class="form-control-panier quantity-input-panier" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td><?= number_format($item->typeMassage->prix * $item->quantite, 2) ?> €</td>
                        <td>
                            <a href="<?= base_url('panier/supprimer/' . $item->type_massage_id) ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</a>
                            <a href="<?= base_url('massage_details/' . $item->type_massage_id) ?>" class="btn">Détails du massage</a>
                        </td>
                    </tr>
                    <?php $total += $item->typeMassage->prix * $item->quantite; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2"><strong><?= number_format($total, 2) ?> €</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="cart-actions-panier">
            <a href="<?= base_url('TypesMassages') ?>" class="btn">Continuer mes achats</a>
            <a href="<?= base_url('panier/vider') ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?')">Vider le panier</a>
            <a href="<?= base_url('panier/validerCommande') ?>" class="btn">Valider la commande</a>
        </div>
    <?php endif; ?>
</body>

</html>