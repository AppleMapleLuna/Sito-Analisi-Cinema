<?php
require_once '../src/database/php.conndatabase.php';
require_once '../src/auth/film_repository.php';

FilmRepository::init($conn);

$id = $_GET['id'] ?? null;
if (!$id) die("Film non trovato.");

$film = FilmRepository::getFilmFull($id);
$actors = FilmRepository::getActors($id);
$reviews = FilmRepository::getReviews($id);
$rating = FilmRepository::getRating($id);
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($film['Titolo']) ?></title>
<link rel="stylesheet" href="assets/css/film_dettagli.css">
<link rel="stylesheet" href="assets/components/navbar_style.css">
</head>
<body>
<?php include __DIR__ . '/assets/components/navbar.php'; ?>
<div class="film-container">

    <div class="poster">
        <img src="<?= $film['Immagine'] ?>" alt="<?= $film['Titolo'] ?>">
    </div>

    <div class="info">
        <h1><?= $film['Titolo'] ?></h1>
        <p><strong>Anno:</strong> <?= $film['Anno'] ?></p>
        <p><strong>Genere:</strong> <?= $film['Nome_Genere'] ?></p>
        <p><strong>Regista:</strong> <?= $film['RegistaNome'] . " " . $film['RegistaCognome'] ?></p>
        <p><strong>Durata:</strong> <?= $film['Durata'] ?></p>
        <p><strong>Trama:</strong> <?= $film['Trama'] ?></p>

        <p><strong>Valutazione media:</strong> <?= $rating ? round($rating, 1) : "N/A" ?></p>

        <h2>Attori</h2>
        <ul>
            <?php foreach ($actors as $a): ?>
                <li><?= $a['Nome'] . " " . $a['Cognome'] ?></li>
            <?php endforeach; ?>
        </ul>

        <?php if (isset($_SESSION['user'])): ?>
            <div class="review-form">
                <h3>Scrivi una recensione</h3>

                <form action="../src/auth/salva_recensione.php" method="POST">
                    <input type="hidden" name="film_id" value="<?= $id ?>">

                    <label for="testo">La tua recensione</label>
                    <textarea name="testo" id="testo" rows="4" required></textarea>

                    <label for="voto">Voto (1–10)</label>
                    <select name="voto" id="voto" required>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>

                    <button type="submit">Invia recensione</button>
                </form>
            </div>
        <?php else: ?>
            <p><a href="login.php" class="login-link">Accedi</a> per scrivere una recensione.</p>
        <?php endif; ?>


        <h2>Recensioni</h2>
        <?php foreach ($reviews as $r): ?>
            <div class="review">
                <strong><?= $r['Username'] ?></strong>
                <p><?= $r['Testo'] ?></p>
                <small><?= $r['Data'] ?></small>
            </div>
        <?php endforeach; ?>
    </div>

</div>

</body>
</html>
