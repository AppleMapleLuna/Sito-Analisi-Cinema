document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('votiChart');
    if (!canvas) return;

    const filmId = new URLSearchParams(window.location.search).get('id');
    if (!filmId) return;

    fetch(`../src/api/api_statistiche_film.php?id=${encodeURIComponent(filmId)}`)
        .then(response => response.json())
        .then(data => {
            if (!data.success || data.stats.num_recensioni === 0) return;

            const labels = Object.keys(data.stats.distribuzione);
            const values = Object.values(data.stats.distribuzione);

            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Numero di recensioni',
                        data: values,
                        backgroundColor: ['#facc15', '#fbbf24', '#f59e0b', '#d97706', '#b45309'],
                        borderColor: '#0f172a',
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#facc15',
                            bodyColor: '#eaf7ff'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#334155' },
                            ticks: { color: '#eaf7ff', stepSize: 1 },
                            title: { display: true, text: 'Numero recensioni', color: '#facc15' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#eaf7ff' },
                            title: { display: true, text: 'Intervallo di voto', color: '#facc15' }
                        }
                    }
                }
            });
        })
        .catch(err => console.error('Errore nel caricamento statistiche:', err));
});