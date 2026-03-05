<?php
session_start();
$error = $_GET['e'] ?? '';
$ok = $_GET['ok'] ?? '';
?>
<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Registrazione</title>
    <link rel="stylesheet" href="../src/template/style.css">
</head>
<body>
    <div class="card">
        <h2>REGISTRAZIONE</h2>

        <?php if($error): ?>
            <div class="error">Errore nella registrazione</div>
        <?php endif; ?>

        <?php if($ok): ?>
            <div class="success">Controlla la tua email per confermare l’account</div>
        <?php endif; ?>

        <form method="post" action="../src/auth/register.php">
            <input name="email" placeholder="Email" required>
            <input name="username" placeholder="Username" required>
            <input name="password" type="password" placeholder="Password" required>
            <button>REGISTRATI</button>
        </form>

        <a href="login.php"><button>Vai al login</button></a>
    </div>
</body>
</html>
