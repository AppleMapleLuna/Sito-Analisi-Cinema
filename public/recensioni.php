<?php
require_once __DIR__ . '/../src/database/php.conndatabase.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Recensioni</title>
<link rel="stylesheet" href="../src/template/pages/style_recensione.css">
</head>
<body>

<div class="form-container">
<h2>Scrivi recensione</h2>
<form action="../src/auth/salva_recensione.php" method="POST">
<input type="text" name="nome" placeholder="Nome" required>
<input type="text" name="film" placeholder="Film" required>

<div class="stars">
<span data-value="1">★</span><span data-value="2">★</span><span data-value="3">★</span>
<span data-value="4">★</span><span data-value="5">★</span><span data-value="6">★</span>
<span data-value="7">★</span><span data-value="8">★</span><span data-value="9">★</span>
<span data-value="10">★</span>
</div>

<input type="hidden" name="voto" id="voto" required>
<textarea name="commento" placeholder="Commento" required></textarea>
<button type="submit">Invia</button>
</form>
</div>

<?php
$res = $conn->query("SELECT * FROM recensioni ORDER BY data DESC");
while($r = $res->fetch_assoc()){
?>
<div class="rec-card">
<h3><?= $r['film'] ?> ⭐ <?= $r['voto'] ?></h3>
<p><?= $r['commento'] ?></p>
<form action="../src/auth/elimina_recensione.php" method="POST">
<input type="hidden" name="id" value="<?= $r['id'] ?>">
<button class="delete-btn">Elimina</button>
</form>
</div>
<?php } ?>

<script src="../src/scripts/script_recensione.js"></script>
</body>
</html>