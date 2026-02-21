<?php
session_start();
if(empty($_SESSION['user'])){
  header("Location: login.php");
  exit;
}
?>
<!doctype html>
<html><body style="background:#070612;color:#eaf7ff;font-family:system-ui">
<h1>Benvenuto <?=htmlspecialchars($_SESSION['user']['name'])?></h1>
<a href="logout.php">Logout</a>
</body></html>