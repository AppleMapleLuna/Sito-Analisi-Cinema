<?php
session_start();
if (!empty($_SESSION['user'])) {
  header("Location: dashboard.php");
  exit;
}
$error = $_GET['e'] ?? '';
?>
<!doctype html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <title>Neon Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../src/template/style_login.css">
  </head>
  <body>
    <div class="card">
      <h2>ACCESSO</h2>
      <?php if($error): ?><div class="error">Login errato</div><?php endif; ?>
      <form method="post" action="../src/auth/login.php">
        <input name="email" placeholder="email" required>
        <input name="password" type="password" placeholder="password" required>
        <button>LOGIN</button>
      </form>
      <a href="register.php"><button>Registrati</button></a>
    </div>
  </body>
</html>