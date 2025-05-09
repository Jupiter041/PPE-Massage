<?= $this->include('TypesMassages/Templates/header') ?>
<?= $this->include('TypesMassages/Templates/adminnav') ?>
<?= $this->include('TypesMassages/Templates/navbar') ?>

<div class="container">
    <h2>Heures travaillées par employé</h2>
    
    <table class="table">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Heures ce mois</th>
                <th>Total heures</th>
                <th>Détail des créneaux</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employes as $employe): ?>
            <tr>
                <td><?= $employe['nom'] ?></td>
                <td><?= number_format($employe['heures_mois']/60, 1) ?>h</td>
                <td><?= number_format($employe['heures_total']/60, 1) ?>h</td>
                <td>
                    <button class="btn btn-info btn-details" data-id="<?= $employe['employe_id'] ?>">
                        Voir les créneaux
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="detailsModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Détail des créneaux</h3>
        <div id="timeslots"></div>
    </div>
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
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    cursor: pointer;
}
</style>

<script>
document.querySelectorAll('.btn-details').forEach(btn => {
    btn.addEventListener('click', async () => {
        const employeId = btn.dataset.id;
        const response = await fetch(`/api/employe/${employeId}/creneaux`);
        const creneaux = await response.json();
        
        document.getElementById('timeslots').innerHTML = creneaux
            .map(c => `<p>${c.date} : ${c.debut} - ${c.fin} (${c.duree} min)</p>`)
            .join('');
        
        document.getElementById('detailsModal').style.display = 'block';
    });
});

document.querySelector('.close').addEventListener('click', () => {
    document.getElementById('detailsModal').style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target == document.getElementById('detailsModal')) {
        document.getElementById('detailsModal').style.display = 'none';
    }
});
</script>

<?= $this->include('TypesMassages/Templates/footer') ?>