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
<link rel="stylesheet" href="../src/template/pages/film_dettagli.css">
</head>
<body>

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
