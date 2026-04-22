<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['admin'] !== 1) {
    header("Location: ../../public/login.php");
    exit;
}

require_once __DIR__ . '/../database/php.conndatabase.php';

// Dati POST
$id      = (int)($_POST['id'] ?? 0);
$titolo  = trim($_POST['titolo'] ?? '');
$anno    = (int)($_POST['anno'] ?? 0);
$durata  = !empty($_POST['durata']) ? (int)$_POST['durata'] : null;
$trama   = trim($_POST['trama'] ?? '');
$regista = (int)($_POST['regista_id'] ?? 0);
$img_url = trim($_POST['immagine_url'] ?? '');

// Validazione
if ($id <= 0 || empty($titolo) || $anno < 1900 || $anno > 2026 || $regista <= 0) {
    $_SESSION['message'] = "Errore: dati non validi.";
    header("Location: ../../public/dashboard.php");
    exit;
}

// Aggiorna film
$stmt = $conn->prepare("
    UPDATE film 
    SET Titolo = ?, Anno = ?, Durata = ?, Trama = ?, ID_Regista = ?
    WHERE ID_film = ?
");
$stmt->bind_param("sissii", $titolo, $anno, $durata, $trama, $regista, $id);
$stmt->execute();

// Aggiorna immagine
$stmtDel = $conn->prepare("DELETE FROM immagini WHERE ID_Film = ?");
$stmtDel->bind_param("i", $id);
$stmtDel->execute();

if (!empty($img_url)) {
    $stmt2 = $conn->prepare("
        INSERT INTO immagini (URL, Descrizione, ID_Film)
        VALUES (?, 'Poster', ?)
    ");
    $stmt2->bind_param("si", $img_url, $id);
    $stmt2->execute();
}

$_SESSION['message'] = "Film aggiornato con successo!";
header("Location: ../../public/dashboard.php");
exit;
