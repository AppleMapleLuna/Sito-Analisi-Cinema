<?php
session_start();
if (!empty($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Benvenuto</title>
    <link rel="stylesheet" href="template/style.css">
</head>
<body>
    <div class="card">
        <h2>BENVENUTO</h2>
        <p>Inserisci qua l'algoritmo con i film più recentemente aggiunti o qualcosa del genere!</p>
        <a href="login.php"><button>VAI AL LOGIN</button></a>
    </div>
</body>
</html>
