<?php
session_start();
require_once __DIR__ . '/../database/php.conndatabase.php';

$id = $_POST['id'];
$titolo = $_POST['titolo'];
$anno = $_POST['anno'];
$durata = $_POST['durata'];
$trama = $_POST['trama'];
$regista = $_POST['regista_id'];
$img_url = $_POST['immagine_url'];

// Aggiorna film
$stmt = $conn->prepare("
    UPDATE film 
    SET Titolo=?, Anno=?, Durata=?, Trama=?, ID_Regista=?
    WHERE ID_film=?
");
$stmt->bind_param("sisssi", $titolo, $anno, $durata, $trama, $regista, $id);
$stmt->execute();

// Aggiorna immagine
$conn->query("DELETE FROM immagini WHERE ID_Film = $id");

if (!empty($img_url)) {
    $stmt2 = $conn->prepare("INSERT INTO immagini (URL, Descrizione, ID_Film) VALUES (?, 'Poster', ?)");
    $stmt2->bind_param("si", $img_url, $id);
    $stmt2->execute();
}

$_SESSION['message'] = "Film aggiornato!";
header("Location: /dashboard.php");
exit;
