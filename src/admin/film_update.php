<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['admin'] !== 1) {
    header("Location: ../../public/login.php");
    exit;
}

require_once __DIR__ . '/../database/php.conndatabase.php';
require_once __DIR__ . '/../auth/film_repository.php';

// Inizializza la connessione nel repository
FilmRepository::init($conn);
echo "<pre>";
var_dump($_POST);
echo "</pre>";
exit;


// Dati POST
$data = [
    'id'         => (int)($_POST['id'] ?? 0),
    'titolo'     => trim($_POST['titolo'] ?? ''),
    'anno'       => (int)($_POST['anno'] ?? 0),
    'durata'     => !empty($_POST['durata']) ? (int)$_POST['durata'] : null,
    'trama'      => trim($_POST['trama'] ?? ''),
    'regista_id' => (int)($_POST['regista_id'] ?? 0),
    'img_url'    => trim($_POST['immagine_url'] ?? '')
];

// Validazione
if (
    $data['id'] <= 0 ||
    empty($data['titolo']) ||
    $data['anno'] < 1900 ||
    $data['anno'] > 2026 ||
    $data['regista_id'] <= 0
) {
    $_SESSION['message'] = "Errore: dati non validi.";
    header("Location: ../../public/dashboard.php");
    exit;
}

// Aggiorna film
FilmRepository::updateFilm($data);

// Aggiorna immagine
$stmtDel = $conn->prepare("DELETE FROM immagini WHERE ID_Film = ?");
$stmtDel->bind_param("i", $data['id']);
$stmtDel->execute();

if (!empty($data['img_url'])) {
    $stmt2 = $conn->prepare("
        INSERT INTO immagini (URL, Descrizione, ID_Film)
        VALUES (?, 'Poster', ?)
    ");
    $stmt2->bind_param("si", $data['img_url'], $data['id']);
    $stmt2->execute();
}

$_SESSION['message'] = "Film aggiornato con successo!";
header("Location: ../../public/dashboard.php");
exit;
