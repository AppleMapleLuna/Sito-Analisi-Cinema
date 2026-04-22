<?php
require_once __DIR__ . '/../src/database/php.conndatabase.php';

$id = $_GET['id'] ?? 0;
if (!$id) die("ID film mancante");

// Info film
$stmt = $conn->prepare("
    SELECT f.ID_Film, f.Titolo, f.Anno, r.Nome, r.Cognome,
           (SELECT URL FROM immagini WHERE ID_Film = f.ID_Film LIMIT 1) AS poster
    FROM film f
    LEFT JOIN registi r ON f.ID_Regista = r.ID_Regista
    WHERE f.ID_Film = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$film = $stmt->get_result()->fetch_assoc();

if (!$film) die("Film non trovato");

// Statistiche voti
$stmt2 = $conn->prepare("
    SELECT COUNT(*) AS num_recensioni, AVG(Voto) AS voto_medio 
    FROM valutazioni 
    WHERE ID_Film = ?
");
$stmt2->bind_param("i", $id);
$stmt2->execute();
$stats = $stmt2->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Statistiche: <?= htmlspecialchars($film['Titolo']) ?></title>

    <!-- CSS CORRETTO -->
    <link rel="stylesheet" href="assets/css/stile_statistiche_film.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>

    <!-- NAVBAR CORRETTA -->
    <?php include __DIR__ . '/assets/components/navbar.php'; ?>

    <div class="statistiche-container">

        <!-- LINK CORRETTO -->
        <a href="film.php?id=<?= $id ?>" class="back-link">← Torna al film</a>

        <div class="film-header">
            <?php if (!empty($film['poster'])): ?>
                <img src="<?= htmlspecialchars($film['poster']) ?>" alt="Poster" class="film-poster">
            <?php else: ?>
                <div class="poster-placeholder">No poster</div>
            <?php endif; ?>

            <div class="film-info">
                <h1><?= htmlspecialchars($film['Titolo']) ?> (<?= $film['Anno'] ?>)</h1>
                <p class="regista">Regia: <?= htmlspecialchars($film['Nome'] . ' ' . $film['Cognome']) ?></p>
            </div>
        </div>

        <div class="stats-overview">
            <div class="stat-card">
                <span class="stat-label">Voto medio</span>
                <span class="stat-value"><?= $stats['voto_medio'] ? number_format($stats['voto_medio'],1) : 'N/D' ?> / 10</span>
            </div>

            <div class="stat-card">
                <span class="stat-label">Numero recensioni</span>
                <span class="stat-value"><?= $stats['num_recensioni'] ?></span>
            </div>
        </div>

        <?php if ($stats['num_recensioni'] > 0): ?>
            <div class="chart-container">
                <h2>Distribuzione dei voti</h2>
                <canvas id="votiChart"></canvas>
            </div>
        <?php else: ?>
            <p class="no-reviews">Ancora nessuna recensione per questo film.</p>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/assets/components/componente_footer.php'; ?>
    <script src="assets/scripts/script_statistiche_film.js"></script>

</body>
</html>
