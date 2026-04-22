<?php
session_start();
require_once __DIR__ . '/../src/database/php.conndatabase.php';

// Se l'utente non è loggato, può solo leggere
$logged = isset($_SESSION['user']);
$userId = $logged ? $_SESSION['user']['ID_Utente'] : null;

// Recupera tutte le recensioni con film e voto
$query = "
    SELECT r.ID_Recensione, r.Testo, r.Data,
           f.Titolo,
           COALESCE(v.Voto, 'N/A') AS Voto,
           u.Username
    FROM recensioni r
    JOIN film f ON r.ID_Film = f.ID_film
    JOIN utenti u ON r.ID_Utente = u.ID_Utente
    LEFT JOIN valutazioni v 
        ON r.ID_Film = v.ID_Film AND r.ID_Utente = v.ID_Utente
    ORDER BY r.Data DESC
";

$recensioni = $conn->query($query)->fetch_all(MYSQLI_ASSOC);

// Recupera lista film per il form
$filmList = $conn->query("SELECT ID_film, Titolo FROM film ORDER BY Titolo ASC")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Recensioni</title>
<link rel="stylesheet" href="assets/css/style_recensione.css">
</head>
<body>

<h1 class="title">📝 Recensioni degli utenti</h1>

<!-- FORM SCRITTURA RECENSIONE -->
<?php if ($logged): ?>
<div class="form-container">
    <h2>Scrivi una recensione</h2>

    <form action="../src/auth/salva_recensione.php" method="POST">

        <label>Film</label>
        <select name="film_id" required>
            <option value="">Seleziona un film...</option>
            <?php foreach ($filmList as $f): ?>
                <option value="<?= $f['ID_film'] ?>"><?= htmlspecialchars($f['Titolo']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Voto (1–10)</label>
        <select name="voto" required>
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>

        <label>Commento</label>
        <textarea name="testo" placeholder="Scrivi qui la tua recensione..." required></textarea>

        <button type="submit">Invia</button>
    </form>
</div>
<?php else: ?>
    <p class="login-warning">
        <a href="login.php">Accedi</a> per scrivere una recensione.
    </p>
<?php endif; ?>


<!-- LISTA RECENSIONI -->
<div class="rec-list">
<?php foreach ($recensioni as $r): ?>
    <div class="rec-card">
        <h3><?= htmlspecialchars($r['Titolo']) ?> — ⭐ <?= $r['Voto'] ?></h3>
        <p class="author">di <?= htmlspecialchars($r['Username']) ?> — <small><?= $r['Data'] ?></small></p>
        <p><?= nl2br(htmlspecialchars($r['Testo'])) ?></p>

        <?php if ($logged && $r['Username'] === $_SESSION['user']['Username']): ?>
            <form action="../src/auth/elimina_recensione.php" method="POST">
                <input type="hidden" name="id" value="<?= $r['ID_Recensione'] ?>">
                <button class="delete-btn">Elimina</button>
            </form>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</div>

</body>
</html>
