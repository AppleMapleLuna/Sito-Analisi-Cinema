<?php
require_once __DIR__ . '/../database/php.conndatabase.php';
$nome=$_POST['nome'];
$film=$_POST['film'];
$voto=$_POST['voto'];
$commento=$_POST['commento'];
$conn->query("INSERT INTO recensioni (nome,film,voto,commento) VALUES ('$nome','$film','$voto','$commento')");
header("Location: ../../public/recensioni.php");
?>