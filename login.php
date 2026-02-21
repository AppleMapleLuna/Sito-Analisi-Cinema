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
<style>
body{
  margin:0;
  font-family:system-ui;
  min-height:100vh;
  display:grid;
  place-items:center;
  background:#05040a;
  color:#eaf7ff;
}
.card{
  width:380px;
  padding:24px;
  border-radius:18px;
  background:rgba(255,255,255,.05);
  box-shadow:0 0 40px #00f5ff55;
}
input,button{
  width:100%;
  padding:12px;
  margin-top:10px;
  border-radius:12px;
  border:none;
}
button{
  background:linear-gradient(90deg,#00f5ff,#ff2bd6);
  color:black;
  font-weight:bold;
  cursor:pointer;
}
.error{color:#ff2bd6;margin-top:10px;}
</style>
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