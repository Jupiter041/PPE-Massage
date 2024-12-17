<?= $this->include('TypesMassages/Templates/header.php') ?>
<body>
    <div class="container fade-in">
        <div class="booking-form-container">
            <h1 class="booking-title">Réservation de Votre Séance de Massage</h1>
            <p class="booking-description">Découvrez un moment de pure détente dans notre espace bien-être. Notre équipe de professionnels qualifiés vous accueille dans une ambiance zen et apaisante.</p>
            
            <form action="<?= base_url('Reservations/create') ?>" method="POST" class="elegant-form">
                <?= csrf_field() ?>
                <input type="hidden" name="TypeMassage" value="<?= isset($typeMassage) ? $typeMassage->type_id : '' ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="Civilite">Civilité</label>
                        <select id="Civilite" name="Civilite" class="form-control" required>
                            <option value="">Choisir...</option>
                            <option value="Mme">Madame</option>
                            <option value="M">Monsieur</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Nom">Nom et Prénom</label>
                        <input type="text" id="Nom" name="Nom" class="form-control" value="<?= session()->get('name') ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="Email">Adresse Email</label>
                        <input type="email" id="Email" name="Email" class="form-control" value="<?= session()->get('email') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="Telephone">Numéro de Téléphone</label>
                        <input type="tel" id="Telephone" name="Telephone" class="form-control" placeholder="0612345678" pattern="[0-9]{10}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="Duree">Durée de la Séance</label>
                        <select id="Duree" name="Duree" class="form-control" required>
                            <option value="">Sélectionnez la durée...</option>
                            <option value="30">30 minutes - Massage Express</option>
                            <option value="60">60 minutes - Massage Classique</option>
                            <option value="90">90 minutes - Massage Premium</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Praticien">Préférence Praticien(ne)</label>
                        <select id="Praticien" name="Praticien" class="form-control">
                            <option value="">Sans préférence</option>
                            <option value="F">Praticienne</option>
                            <option value="H">Praticien</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="Date">Date Souhaitée</label>
                        <input type="date" id="Date" name="Date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="Heure">Horaire Souhaité</label>
                        <input type="time" id="Heure" name="Heure" class="form-control" min="09:00" max="20:00" required>
                        <small class="form-text text-muted">Horaires d'ouverture : 9h - 20h</small>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="Com">Informations Complémentaires</label>
                    <textarea id="Com" name="Com" class="form-control" rows="5" placeholder="Merci de nous informer de toute condition médicale particulière, zones à éviter, ou préférences spécifiques pour votre massage..."></textarea>
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
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<script>
// Restriction des dates passées
document.getElementById('Date').min = new Date().toISOString().split('T')[0];
</script>

<?= $this->include('TypesMassages/Templates/footer.php') ?>
