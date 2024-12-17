
<!DOCTYPE html>
<html>
<head>
    <title>Mon Panier</title>
</head>
<body>
    <h2>Mon Panier</h2>

    <?php if (session()->has('message')): ?>
        <div class="alert alert-success">
            <?= session()->get('message') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <p>Votre panier est vide.</p>
        <a href="<?= base_url('TypesMassages') ?>" class="btn btn-primary">Continuer mes achats</a>
    <?php else: ?>
        <table class="table">
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
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= esc($item->nom_type) ?></td>
                        <td><?= number_format($item->prix, 2) ?> €</td>
                        <td>
                            <form action="<?= base_url('panier/updateQuantite') ?>" method="post" class="quantity-form">
                                <input type="hidden" name="panier_id" value="<?= $item->panier_id ?>">
                                <input type="number" name="quantite" value="<?= $item->quantite ?>" min="1" class="form-control quantity-input" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td><?= number_format($item->prix * $item->quantite, 2) ?> €</td>
                        <td>
                            <a href="<?= base_url('panier/supprimer/' . $item->panier_id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php $total += $item->prix * $item->quantite; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2"><strong><?= number_format($total, 2) ?> €</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="cart-actions">
            <a href="<?= base_url('TypesMassages') ?>" class="btn btn-primary">Continuer mes achats</a>
            <a href="<?= base_url('panier/vider') ?>" class="btn btn-warning" onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?')">Vider le panier</a>
            <button class="btn btn-success">Procéder au paiement</button>
        </div>
    <?php endif; ?>
</body>
</html>
