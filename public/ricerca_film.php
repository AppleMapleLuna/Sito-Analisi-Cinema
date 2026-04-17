<?php
    require_once '../src/auth/film_repository.php';

    // Read filters from GET
    $search = $_GET['search'] ?? '';
    $year = $_GET['year'] ?? '';
    $sort = $_GET['sort'] ?? '';

    $films = FilmRepository::getAllFilms();

    // FILTERING IN PHP
    $films = array_filter($films, function($film) use ($search, $year) {
        $matchSearch = empty($search) || stripos($film['Titolo'], $search) !== false;
        $matchYear = empty($year) || $film['Anno'] == $year;
        return $matchSearch && $matchYear;
    });

    // SORTING
    if ($sort === 'title_asc') {
        usort($films, fn($a, $b) => strcmp($a['Titolo'], $b['Titolo']));
    }
    if ($sort === 'title_desc') {
        usort($films, fn($a, $b) => strcmp($b['Titolo'], $a['Titolo']));
    }
    if ($sort === 'year_desc') {
        usort($films, fn($a, $b) => $b['Anno'] <=> $a['Anno']);
    }

    if ($sort === 'year_asc') {
        usort($films, fn($a, $b) => $a['Anno'] <=> $b['Anno']);
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricerca film</title>
    <link rel="stylesheet" href="../src/template/pages/film_ricerca_style.css">
</head>
<body>

    <h1>Ricerca film</h1>

    <form class="film-filters" method="GET">
        <input type="text" name="search" placeholder="Cerca per titolo..." value="<?= htmlspecialchars($search) ?>">

        <select name="year">
            <option value="">Tutti gli anni</option>
            <?php foreach (range(date("Y"), 1900) as $y): ?>
                <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>><?= $y ?></option>
            <?php endforeach; ?>
        </select>

        <select name="sort">
            <option value="">Ordina per...</option>
            <option value="title_asc"  <?= $sort === 'title_asc' ? 'selected' : '' ?>>Titolo A-Z</option>
            <option value="title_desc" <?= $sort === 'title_desc' ? 'selected' : '' ?>>Titolo Z-A</option>
            <option value="year_desc"  <?= $sort === 'year_desc' ? 'selected' : '' ?>>Anno ↓</option>
            <option value="year_asc"   <?= $sort === 'year_asc' ? 'selected' : '' ?>>Anno ↑</option>
        </select>

        <button type="submit">Filtra</button>
    </form>


    <div class="film-list">
        <?php foreach ($films as $film): ?>
            <?php include '../src/template/components/film-card.php'; ?>
        <?php endforeach; ?>
    </div>

</body>
</html>