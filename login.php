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
<link rel="stylesheet" href="template/style.css">
</head>
<body>
<div class="card">
<h2>ACCESSO</h2>
<?php if($error): ?><div class="error">Login errato</div><?php endif; ?>
<form method="post" action="auth.php">
<input name="email" placeholder="email" required>
<input name="password" type="password" placeholder="password" required>
<button>LOGIN</button>
</form>
</div>
</body>
</html>