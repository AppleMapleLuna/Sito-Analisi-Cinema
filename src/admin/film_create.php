<?php

if (!isset($_SESSION['user_id']) || $_SESSION['admin'] !== 1) {
    header('Location: ../../public/login.php');
    exit;
}
require_once '../database/php.conndatabase.php';


// Dati da passare
$titolo = trim($_POST['titolo'] ?? '');
$anno = (int)($_POST['anno'] ?? 0);
$durata = !empty($_POST['durata']) ? (int)$_POST['durata'] : null;
$trama = trim($_POST['trama'] ?? '');
$regista_id = (int)($_POST['regista_id'] ?? 0);
$img_url = $_POST['immagine_url'] ?? null;

// Controllo validazione dati
if (empty($titolo) || $anno < 1900 || $anno > 2026 || $regista_id <= 0) {
    $_SESSION['message'] = 'Errore: dati non validi per la creazione del film.';
    header('Location: dashboard_admin.php');
    exit;
}

// Inserimento dei dati per creare un nuovo film
$stmt = $conn->prepare("INSERT INTO film (Titolo, Anno, Durata, Trama, ID_Regista) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sisss", $titolo, $anno, $durata, $trama, $regista);
$stmt->execute();

$film_id = $conn->insert_id;

// Se l'URL dell'immagine non è vuota, si salva qua
if (!empty($img_url)) {
    $stmt2 = $conn->prepare("INSERT INTO immagini (URL, Descrizione, ID_Film) VALUES (?, 'Poster', ?)");
    $stmt2->bind_param("si", $img_url, $film_id);
    $stmt2->execute();
}

$_SESSION['message'] = "Film creato con successo!";
header('Location: dashboard_admin.php');
exit;