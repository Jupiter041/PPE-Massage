<h2>Réservations en Attente</h2>

<div class="elegant-form">
    <form action="<?= base_url('EnAttente/create') ?>" method="POST" class="elegant-form">
        <?= csrf_field() ?>
        <input type="hidden" name="type_id" value="<?= $type_id ?? '' ?>">
        <input type="hidden" name="panier_id" value="<?= $panier ? $panier->panier_id : '' ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="heure_reservation">Date Souhaitée</label>
                <input type="date" id="heure_reservation" name="heure_reservation" class="form-control" required
                        min="<?= date('Y-m-d') ?>"
                        value="<?= isset($reservation) ? date('Y-m-d', strtotime($reservation->heure_reservation)) : '' ?>">
            </div>

            <div class="form-group">
                <label for="duree">Durée de la Séance</label>
                <select id="duree" name="duree" class="form-control" required>
                    <option value="">Sélectionnez la durée...</option>
                    <option value="30" <?= isset($reservation) && $reservation->duree == 30 ? 'selected' : '' ?>>30 minutes</option>
                    <option value="60" <?= isset($reservation) && $reservation->duree == 60 ? 'selected' : '' ?>>60 minutes</option>
                    <option value="90" <?= isset($reservation) && $reservation->duree == 90 ? 'selected' : '' ?>>90 minutes</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="heure">Horaire Souhaité</label>
            <select id="heure" name="heure" class="form-control" required <?= !isset($reservation) ? 'disabled' : '' ?>>
                <?php if (isset($reservation)): ?>
                    <option value="<?= date('H:i', strtotime($reservation->heure_reservation)) ?>" selected>
                        <?= date('H:i', strtotime($reservation->heure_reservation)) ?>
                    </option>
                <?php else: ?>
                    <option value="">Sélectionnez d'abord une date et une durée</option>
                <?php endif; ?>
            </select>
            <small class="form-text text-muted">Horaires d'ouverture : 9h - 20h</small>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="preference_praticien">Préférence Praticien(ne)</label>
                <select id="preference_praticien" name="preference_praticien" class="form-control">
                    <option value="">Sans préférence</option>
                    <option value="F" <?= isset($reservation) && $reservation->preference_praticien == 'F' ? 'selected' : '' ?>>Praticienne</option>
                    <option value="H" <?= isset($reservation) && $reservation->preference_praticien == 'H' ? 'selected' : '' ?>>Praticien</option>
                </select>
            </div>
        </div>

        <div class="form-group full-width">
            <label for="commentaires">Informations Complémentaires</label>
            <textarea id="commentaires" name="commentaires" class="form-control" rows="5"><?= isset($reservation) ? esc($reservation->commentaires) : '' ?></textarea>
        </div>

        <div class="form-group full-width">
            <label class="checkbox-container">
                <input type="checkbox" required>
                <span class="checkmark"></span>
                J'accepte les conditions générales et la politique de confidentialité
            </label>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= isset($reservation) ? 'Mettre à jour la réservation' : 'Confirmer ma Réservation' ?>
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (isset($reservation)): ?>
        // Si une réservation existe, active le champ heure
        document.getElementById('heure').disabled = false;
    <?php endif; ?>

    const dateInput = document.getElementById('heure_reservation');
    const durationSelect = document.getElementById('duree');
    const timeSelect = document.getElementById('heure');
    
    function updateTimeSlots() {
        const selectedDate = dateInput.value;
        const selectedDuration = durationSelect.value;
        
        if (!selectedDate || !selectedDuration) {
            timeSelect.innerHTML = '<option value="">Sélectionnez d\'abord une date et une durée</option>';
            timeSelect.disabled = true;
            return;
        }
        
        // Afficher un indicateur de chargement
        timeSelect.innerHTML = '<option value="">Chargement des créneaux...</option>';
        timeSelect.disabled = true;
        
        // Faire la requête AJAX
        fetch(`<?= base_url('EnAttente/getAvailableSlots') ?>?date=${selectedDate}&duration=${selectedDuration}`)
            .then(response => {
                if (!response.ok) throw new Error('Erreur réseau');
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    timeSelect.innerHTML = `<option value="">${data.error}</option>`;
                    return;
                }
                
                if (data.slots.length === 0) {
                    timeSelect.innerHTML = '<option value="">Aucun créneau disponible pour cette durée</option>';
                } else {
                    timeSelect.innerHTML = '<option value="">Sélectionnez un horaire</option>';
                    data.slots.forEach(slot => {
                        timeSelect.innerHTML += `<option value="${slot}">${slot}</option>`;
                    });
                    timeSelect.disabled = false;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                timeSelect.innerHTML = '<option value="">Erreur lors du chargement</option>';
            });
    }
    
    // Écoute les changements sur la date et la durée
    dateInput.addEventListener('change', updateTimeSlots);
    durationSelect.addEventListener('change', updateTimeSlots);
});
</script>

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
