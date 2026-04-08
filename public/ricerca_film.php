<?php
    require_once '../src/auth/film_repository.php';
    $films = FilmRepository::getAllFilms();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricerca film</title>
    <link rel="stylesheet" href="./src/template/pages/film_ricerca_style.css">
</head>
<body>
    <h1>Ricerca film</h1>

    <div class="film-list">
        <?php foreach ($films as $film): ?>
            <?php include '../src/template/components/film-card.php'; ?>
        <?php endforeach; ?>
    </div>

</body>
</html>