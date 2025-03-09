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
                        <button onclick="openMassageDetails(<?= $item->type_massage_id ?>)" class="btn btn-primary">Réserver ce massage</button>
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
    <!-- Modal pour le formulaire de réservation -->
    <div id="massageDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <form id="reservationForm" method="post">
                <h2>Réserver votre massage</h2>
                
                <input type="hidden" name="type_id" id="type_massage_id">
                
                <div class="form-group">
                    <label for="date">Date et heure souhaitées:</label>
                    <input type="datetime-local" id="heure_reservation" name="heure_reservation" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="duree">Durée (en minutes):</label>
                    <select id="duree" name="duree" required class="form-control">
                        <option value="30">30 minutes</option>
                        <option value="60">60 minutes</option>
                        <option value="90">90 minutes</option>
                        <option value="120">120 minutes</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="salle_id">Salle:</label>
                    <select id="salle_id" name="salle_id" required class="form-control">
                        <option value="">Choisir une salle</option>
                        <option value="1">Salle de massage 1</option>
                        <option value="2">Salle de massage 2</option>
                        <option value="3">Salle de massage 3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="employe_id">Praticien:</label>
                    <select id="employe_id" name="employe_id" required class="form-control">
                        <option value="">Choisir un praticien</option>
                        <option value="1">Praticien 1</option>
                        <option value="2">Praticien 2</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="preference_praticien">Préférence de praticien:</label>
                    <select id="preference_praticien" name="preference_praticien" class="form-control">
                        <option value="">Aucune préférence</option>
                        <option value="H">Homme</option>
                        <option value="F">Femme</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="commentaires">Commentaires (optionnel):</label>
                    <textarea id="commentaires" name="commentaires" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Sauvegarder la réservation</button>
            </form>
        </div>
    </div>
    <script>
    function openMassageDetails(massageId) {
        const modal = document.getElementById('massageDetailsModal');
        document.getElementById('type_massage_id').value = massageId;
        modal.style.display = "block";
    }

    document.querySelector('.close').onclick = function() {
        document.getElementById('massageDetailsModal').style.display = "none";
    }

    window.onclick = function(event) {
        const modal = document.getElementById('massageDetailsModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    document.getElementById('reservationForm').onsubmit = function(e) {
        e.preventDefault();
        
        // Création de l'objet réservation
        const reservation = {
            type_id: document.getElementById('type_massage_id').value,
            heure_reservation: document.getElementById('heure_reservation').value,
            duree: document.getElementById('duree').value,
            salle_id: document.getElementById('salle_id').value,
            employe_id: document.getElementById('employe_id').value,
            preference_praticien: document.getElementById('preference_praticien').value,
            commentaires: document.getElementById('commentaires').value,
            compte_id: <?= session()->get('compte_id') ?? 1 ?>
        };

        // Sauvegarde dans localStorage
        localStorage.setItem('reservation_temp', JSON.stringify(reservation));
        
        alert('Réservation sauvegardée! Cliquez sur "Valider la commande" pour finaliser.');
        document.getElementById('massageDetailsModal').style.display = "none";
    };

    document.querySelector('a[href*="Commande/valider"]').onclick = function(e) {
        e.preventDefault();
        
        const reservationData = localStorage.getItem('reservation_temp');
        if (!reservationData) {
            alert('Aucune réservation en attente');
            return;
        }

        const reservation = JSON.parse(reservationData);
        
        // Création de la requête SQL
        const sql = `INSERT INTO reservations 
            (heure_reservation, commentaires, duree, salle_id, type_id, employe_id, preference_praticien, compte_id) 
            VALUES 
            ('${reservation.heure_reservation}', 
              '${reservation.commentaires}', 
              ${reservation.duree}, 
              ${reservation.salle_id}, 
              ${reservation.type_id}, 
              ${reservation.employe_id}, 
              ${reservation.preference_praticien ? `'${reservation.preference_praticien}'` : 'NULL'}, 
              ${reservation.compte_id})`;

        // Envoi de la requête au serveur
        fetch('<?= base_url('Reservation/ajouter') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({sql: sql})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                localStorage.removeItem('reservation_temp');
                alert('Réservation enregistrée avec succès!');
                window.location.reload();
            } else {
                alert('Erreur lors de l\'enregistrement de la réservation: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de l\'enregistrement de la réservation');
        });
    };

    function clearReservations() {
        const allStorageKeys = Object.keys(localStorage);
        allStorageKeys.forEach(key => {
            if(key.toLowerCase().includes('reservation')) {
                localStorage.removeItem(key);
            }
        });
        alert('Toutes les réservations ont été supprimées du localStorage');
        window.location.reload();
    }
    </script>
<?php endif; ?>
<div id="debug-storage" style="margin: 20px; padding: 10px; background: #f5f5f5; border: 1px solid #ddd;">
    <h3>Debug LocalStorage et FormData:</h3>
    <button onclick="clearReservations()" class="btn btn-danger">Supprimer toutes les réservations</button>
    <pre>
    <?php
    echo "<script>
        const allStorageKeys = Object.keys(localStorage);
        const reservationFields = allStorageKeys.filter(key => key.toLowerCase().includes('reservation'));
        const reservationData = {};
        
        reservationFields.forEach(key => {
            reservationData[key] = localStorage.getItem(key);
        });
        
        document.write('Champs de réservation:' + JSON.stringify(reservationData, null, 2));
    </script>";
    ?>
    </pre>
</div>
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

