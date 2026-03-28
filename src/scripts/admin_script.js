document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('.delete-form');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const filmTitle = this.getAttribute('data-film') || 'questo film';
            const confirmMsg = `Sei sicuro di voler eliminare "${filmTitle}"? L'operazione è irreversibile.`;
            if (!confirm(confirmMsg)) {
                e.preventDefault();
            }
        });
    });

    const yearInput = document.getElementById('anno');
    if (yearInput) {
        yearInput.addEventListener('change', function() {
            let year = parseInt(this.value);
            if (year < 1900) this.value = 1900;
            if (year > 2026) this.value = 2026;
        });
    }
});