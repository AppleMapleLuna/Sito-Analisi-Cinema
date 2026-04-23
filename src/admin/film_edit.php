<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['admin'] !== 1) {
    header("Location: ../../public/login.php");
    exit;
}

require_once __DIR__ . '/../database/php.conndatabase.php';
require_once __DIR__ . '/../auth/film_repository.php';

// Inizializza connessione
FilmRepository::init($conn);

// Film
$id = $_GET['id'] ?? 0;
$film = FilmRepository::getFilmById($id);

if (!$film) {
    echo "<p>Film non trovato.</p>";
    exit;
}

// Registi
$result = $conn->query("SELECT ID_regista, Nome, Cognome FROM registi ORDER BY Cognome");
$directors = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica Film</title>

    <!-- CSS ADMIN -->
    <link rel="stylesheet" href="../template/admin_style.css">

    <style>
        /* Stile extra per centrare il form */
        .edit-container {
            max-width: 700px;
            margin: 40px auto;
            background: #1e1e1e;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .btn-create {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="edit-container">

    <h2>Modifica Film</h2>

    <form action="/Sito-Analisi-Cinema/src/admin/film_update.php" method="POST" class="film-form">

        <input type="hidden" name="id" value="<?= $film['ID_Film'] ?>">

        <div class="form-group">
            <label>Titolo</label>
            <input type="text" name="titolo" value="<?= htmlspecialchars($film['Titolo']) ?>" required>
        </div>

        <div class="form-group">
            <label>Anno</label>
            <input type="number" name="anno" value="<?= $film['Anno'] ?>" required min="1900" max="2026">
        </div>

        <div class="form-group">
            <label>Durata (minuti)</label>
            <input type="number" name="durata" value="<?= $film['Durata'] ?>">
        </div>

        <div class="form-group">
            <label>Trama</label>
            <textarea name="trama"><?= htmlspecialchars($film['Trama']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Regista</label>
            <select name="regista_id" required>
                <?php foreach ($directors as $dir): ?>
                    <option value="<?= $dir['ID_regista'] ?>"
                        <?= $dir['ID_regista'] == $film['ID_Regista'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dir['Nome'] . ' ' . $dir['Cognome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>URL Immagine</label>
            <input type="text" name="immagine_url" value="<?= htmlspecialchars($film['poster'] ?? '') ?>">
        </div>

        <button type="submit" class="btn-create">Salva modifiche</button>

    </form>

</div>


</body>
</html>
