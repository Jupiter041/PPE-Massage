<h2>Mon Panier</h2>

<?php if (empty($panier)): ?>
    <div class="empty-cart">
        <p>Votre panier est vide</p>
        <a href="<?= base_url('TypesMassages') ?>" class="btn btn-primary">Voir les massages disponibles</a>
    </div>
<?php else: ?>
    <div class="cart-container">
        <ul class="cart-items">
            <?php 
            $total = 0;
            foreach ($panier as $item): 
                $total += $item->getTotal();
            ?>
                <li class="cart-item">
                    <div class="cart-item-info">
                        <p>Panier ID: <?= esc($item->panier_id) ?></p>
                        <p>Type Massage ID: <?= esc($item->type_massage_id) ?></p>
                    </div>
                    <?php if (isset($item->typeMassage->image) && !empty($item->typeMassage->image)): ?>
                        <img src="<?= base_url('assets/images/' . $item->typeMassage->image) ?>" alt="<?= esc($item->typeMassage->nom_type) ?>" class="cart-item-image">
                    <?php endif; ?>
                    <div class="cart-item-details">
                        <h3><?= esc($item->typeMassage->nom_type) ?></h3>
                        <p class="cart-item-price"><?= esc($item->typeMassage->prix) ?> € x <?= esc($item->quantite) ?></p>
                        <p class="cart-item-description"><?= esc($item->typeMassage->description) ?></p>
                    </div>
                    <div class="cart-item-actions">
                        <a href="<?= base_url('TypesMassages/en_attente/' . $item->type_massage_id) ?>" class="btn btn-primary">Réserver</a>
                        <a href="<?= base_url('panier/supprimer/' . $item->type_massage_id) ?>" class="btn btn-remove" onclick="return confirm('Êtes-vous sûr de vouloir retirer cet article du panier ?');">
                            Retirer du panier
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="cart-summary">
            <div class="cart-total">
                <h3>Total</h3>
                <p class="total-amount"><?= $total ?> €</p>
            </div>
            <div class="cart-actions">
                <form action="<?= base_url('reservations/create') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-validate">Valider la commande</button>
                </form>
                <a href="<?= base_url('panier/vider') ?>" class="btn btn-clear" onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?');">
                    Vider le panier
                </a>
            </div>
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

    .cart-item-info {
        margin-bottom: 10px;
        font-size: 0.9em;
        color: #666;
    }
    </style>
<?php endif; ?>
