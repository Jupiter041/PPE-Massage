<?= $this->include('TypesMassages/Templates/header.php') ?>
<body>
    <div class="container fade-in">
        <div class="booking-form-container">
            <h1 class="booking-title">Réservation de Votre Séance de Massage</h1>
            <p class="booking-description">Découvrez un moment de pure détente dans notre espace bien-être. Notre équipe de professionnels qualifiés vous accueille dans une ambiance zen et apaisante.</p>
            
            <form action="<?= base_url('Reservations/create') ?>" method="POST" class="elegant-form">
                <?= csrf_field() ?>
                <input type="hidden" name="type_id" value="<?= isset($typeMassage) ? $typeMassage->type_id : '' ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="civilite">Civilité</label>
                        <select id="civilite" name="civilite" class="form-control" required>
                            <option value="">Choisir...</option>
                            <option value="Mme">Madame</option>
                            <option value="M">Monsieur</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="client_id">Nom et Prénom</label>
                        <input type="text" id="client_id" name="client_id" class="form-control" value="<?= session()->get('name') ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Adresse Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= session()->get('email') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="telephone">Numéro de Téléphone</label>
                        <input type="tel" id="telephone" name="telephone" class="form-control" placeholder="0612345678" pattern="[0-9]{10}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="duree">Durée de la Séance</label>
                        <select id="duree" name="duree" class="form-control" required>
                            <option value="">Sélectionnez la durée...</option>
                            <option value="30">30 minutes - Massage Express</option>
                            <option value="60">60 minutes - Massage Classique</option>
                            <option value="90">90 minutes - Massage Premium</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="preference_praticien">Préférence Praticien(ne)</label>
                        <select id="preference_praticien" name="preference_praticien" class="form-control">
                            <option value="">Sans préférence</option>
                            <option value="F">Praticienne</option>
                            <option value="H">Praticien</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="heure_reservation">Date Souhaitée</label>
                        <input type="date" id="heure_reservation" name="heure_reservation" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="heure">Horaire Souhaité</label>
                        <input type="time" id="heure" name="heure" class="form-control" min="09:00" max="20:00" required>
                        <small class="form-text text-muted">Horaires d'ouverture : 9h - 20h</small>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="commentaires">Informations Complémentaires</label>
                    <textarea id="commentaires" name="commentaires" class="form-control" rows="5" placeholder="Merci de nous informer de toute condition médicale particulière, zones à éviter, ou préférences spécifiques pour votre massage..."></textarea>
                </div>

                <div class="form-group full-width">
                    <label class="checkbox-container">
                        <input type="checkbox" required>
                        <span class="checkmark"></span>
                        J'accepte les conditions générales et la politique de confidentialité
                    </label>
                </div>
                
                <button type="submit" class="btn-submit">Confirmer ma Réservation</button>
            </form>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= is_array(session()->getFlashdata('success')) ? implode('<br>', session()->getFlashdata('success')) : session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= is_array(session()->getFlashdata('error')) ? implode('<br>', session()->getFlashdata('error')) : session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<script>
// Restriction des dates passées
document.getElementById('heure_reservation').min = new Date().toISOString().split('T')[0];
</script>

<?= $this->include('TypesMassages/Templates/footer.php') ?>
