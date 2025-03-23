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
                $total += $item->typeMassage->prix;
            ?>
                <li class="cart-item">
                    <?php if (isset($item->typeMassage->image) && !empty($item->typeMassage->image)): ?>
                        <img src="<?= base_url('assets/images/' . $item->typeMassage->image) ?>" alt="<?= esc($item->typeMassage->nom_type) ?>" class="cart-item-image">
                    <?php endif; ?>
                    <div class="cart-item-details">
                        <h3><?= esc($item->typeMassage->nom_type) ?></h3>
                        <p class="cart-item-price"><?= esc($item->typeMassage->prix) ?> €</p>
                        <p class="cart-item-description"><?= esc($item->typeMassage->description) ?></p>
                    </div>
                    <div class="cart-item-actions">
                        <button onclick="transfererReservation(<?= $item->id ?>)" class="btn btn-primary">Réserver</button>
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
                <a href="<?= base_url('Commande/valider') ?>" class="btn btn-validate">Valider la commande</a>
                <a href="<?= base_url('panier/vider') ?>" class="btn btn-clear" onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?');">
                    Vider le panier
                </a>
            </div>
        </div>
    </div>

    <script>
    function transfererReservation(id) {
        fetch('<?= base_url('Reservations/transfererReservation/') ?>' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Réservation transférée avec succès!');
                window.location.reload();
            } else {
                alert('Erreur lors du transfert de la réservation: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors du transfert de la réservation');
        });
    }
    </script>

    <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        border-radius: 8px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        position: absolute;
        right: 20px;
        top: 10px;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-control {
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

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
    </style>
<?php endif; ?>
