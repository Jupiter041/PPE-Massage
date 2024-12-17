
document.addEventListener('DOMContentLoaded', function() {
    function fetchTypeMassage(id) {
        fetch(`/TypesMassages/details/${id}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.selectedMassage) {
                const massage = data.selectedMassage;
                document.querySelector(`#massage-${id} .massage-description`).innerHTML = massage.description;
                document.querySelector(`#massage-${id} .massage-price`).innerHTML = `${massage.prix} €`;
                if (massage.image) {
                    document.querySelector(`#massage-${id} .massage-image`).src = `/assets/images/${massage.image}`;
                }
            }
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des détails du massage:', error);
        });
    }

    // Ajouter les écouteurs d'événements pour les boutons de détails
    document.querySelectorAll('.massage-type-actions').forEach(item => {
        const massageId = item.closest('li').querySelector('[data-massage-id]')?.dataset.massageId;
        if (massageId) {
            item.querySelector('.btn-add-to-cart').addEventListener('click', (e) => {
                e.preventDefault();
                fetchTypeMassage(massageId);
            });
        }
    });
});
