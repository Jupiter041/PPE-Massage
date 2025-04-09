<h2>Réservations en Attente</h2>

<div class="elegant-form">
    <form action="<?= base_url('EnAttente/create') ?>" method="POST" class="elegant-form">
        <?= csrf_field() ?>
        <input type="hidden" name="type_id" value="<?= $type_id ?? '' ?>">
        <input type="hidden" name="panier_id" value="<?= $panier ? $panier->panier_id : '' ?>">

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
                <label for="salle_id">Salle</label>
                <select id="salle_id" name="salle_id" class="form-control" required>
                    <option value="">Sélectionnez une salle...</option>
                    <option value="1">Salle de massage 1</option>
                    <option value="2">Salle de massage 2</option>
                    <option value="3">Salle de massage 3</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="employe_id">Praticien</label>
                <select id="employe_id" name="employe_id" class="form-control" required>
                    <option value="">Sélectionnez un praticien...</option>
                    <option value="1">Employe 1</option>
                    <option value="2">Employe 2</option>
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

        <button type="submit" class="btn btn-primary">Confirmer ma Réservation</button>
    </form>
</div>

<style>
.elegant-form {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 1rem;
}

.form-group {
    flex: 1;
    min-width: 250px;
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

.full-width {
    width: 100%;
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

.checkbox-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-text {
    color: #6c757d;
    font-size: 0.875rem;
}
</style>

<script>
document.getElementById('heure_reservation').min = new Date().toISOString().split('T')[0];
</script>
