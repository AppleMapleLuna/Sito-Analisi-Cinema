<?php
require_once __DIR__ . '/../../src/auth/film_repository.php';
$film = FilmRepository::getFilmById($_GET['id']);
?>

<h2>Modifica Film</h2>

<form action="/dashboard.php?page=film_save" method="POST">
    <input type="hidden" name="id" value="<?= $film['ID_Film'] ?>">

    <label>Titolo</label><br>
    <input type="text" name="titolo" value="<?= htmlspecialchars($film['Titolo']) ?>"><br><br>

    <label>Anno</label><br>
    <input type="number" name="anno" value="<?= $film['Anno'] ?>"><br><br>

    <label>Durata</label><br>
    <input type="time" name="durata" value="<?= $film['Durata'] ?>"><br><br>

    <label>Trama</label><br>
    <textarea name="trama"><?= htmlspecialchars($film['Trama']) ?></textarea><br><br>

    <button type="submit">Aggiorna</button>
</form>
