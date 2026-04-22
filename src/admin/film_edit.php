<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['admin'] !== 1) {
    header("Location: ../../public/login.php");
    exit;
}

require_once __DIR__ . '/../auth/film_repository.php';

$id = $_GET['id'] ?? 0;
$film = FilmRepository::getFilmById($id);

if (!$film) {
    echo "<p>Film non trovato.</p>";
    exit;
}
?>

<h2>Modifica Film</h2>

<form action="film_update.php" method="POST" class="film-form">

    <input type="hidden" name="id" value="<?= $film['ID_film'] ?>">

    <div class="form-group">
        <label>Titolo</label>
        <input type="text" name="titolo" value="<?= htmlspecialchars($film['Titolo']) ?>" required>
    </div>

    <div class="form-group">
        <label>Anno</label>
        <input type="number" name="anno" value="<?= $film['Anno'] ?>" required>
    </div>

    <div class="form-group">
        <label>Durata (minuti)</label>
        <input type="number" name="durata" value="<?= $film['Durata'] ?>">
    </div>

    <div class="form-group">
        <label>Trama</label>
        <textarea name="trama"><?= htmlspecialchars($film['Trama']) ?></textarea>
    </div>

    <button type="submit" class="btn-create">Salva modifiche</button>
</form>
