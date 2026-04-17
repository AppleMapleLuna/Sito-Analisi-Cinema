<?php
require_once __DIR__ . '/../database/php.conndatabase.php';
$id=$_POST['id'];
$conn->query("DELETE FROM recensioni WHERE id=$id");
header("Location: ../../public/recensioni.php");
?>