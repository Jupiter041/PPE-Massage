<h2>Mon Panier</h2>

<?php if (empty($panier)): ?>
    <div class="empty-cart">
        <p>Votre panier est vide</p>
        <a href="<?= base_url('TypesMassages') ?>" class="btn btn-primary">Voir les massages disponibles</a>
    </div>
<?php else: ?>
    <div class="cart-container">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($panier as $item): 
                    $total += $item->getTotal();
                ?>
                    <tr class="cart-row">
                        <td class="cart-name">
                            <h3><?= esc($item->typeMassage->nom_type) ?></h3>
                            <p class="cart-item-description"><?= esc($item->typeMassage->description) ?></p>
                        </td>
                        <td class="cart-price"><?= esc($item->typeMassage->prix) ?> €</td>
                        <td class="cart-quantity"><?= esc($item->quantite) ?></td>
                        <td class="cart-total"><?= $item->getTotal() ?> €</td>
                        <td class="cart-actions">
                            <?php if ($item->hasPendingReservation): ?>
                                <a href="<?= base_url('TypesMassages/en_attente/' . $item->type_massage_id) ?>" class="btn btn-edit">Modifier</a>
                            <?php else: ?>
                                <a href="<?= base_url('TypesMassages/en_attente/' . $item->type_massage_id) ?>" class="btn btn-primary">Réserver</a>
                            <?php endif; ?>
                            <a href="<?= base_url('panier/supprimer/' . $item->panier_id) ?>" class="btn btn-remove" onclick="return confirm('Êtes-vous sûr de vouloir retirer cet article du panier ?');">
                                Retirer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                    <td colspan="2"><strong><?= $total ?> €</strong></td>
                </tr>
            </tfoot>
        </table>
        <div class="cart-actions">
            <a href="<?= base_url('reservations/create') ?>" class="btn btn-validate" onclick="return confirm('Êtes-vous sûr de vouloir valider votre commande ?');">
                Valider la commande
            </a>
            <a href="<?= base_url('panier/vider') ?>" class="btn btn-clear" onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?');">
                Vider le panier
            </a>
        </div>
    </div>
    <style>
    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
    }

    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border: none;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .cart-table th,
    .cart-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .cart-table th {
        background-color: #f5f5f5;
    }

    .cart-image img {
        max-width: 100px;
        height: auto;
    }

    .text-right {
        text-align: right;
    }

    .cart-actions {
        margin-top: 20px;
        text-align: right;
    }
    </style>
<?php endif; ?>
