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

// Dati POST
$data = [
    'titolo'     => trim($_POST['titolo'] ?? ''),
    'anno'       => (int)($_POST['anno'] ?? 0),
    'durata'     => !empty($_POST['durata']) ? (int)$_POST['durata'] : null,
    'trama'      => trim($_POST['trama'] ?? ''),
    'regista_id' => (int)($_POST['regista_id'] ?? 0),
    'img_url'    => trim($_POST['immagine_url'] ?? '')
];

// Validazione
if (
    empty($data['titolo']) ||
    $data['anno'] < 1900 ||
    $data['anno'] > 2026 ||
    $data['regista_id'] <= 0
) {
    $_SESSION['message'] = "Errore: dati non validi.";
    header("Location: ../../public/dashboard.php");
    exit;
}

// Crea film
FilmRepository::createFilm($data);

// Ottieni ID del film appena creato
$film_id = $conn->insert_id;

// Inserisci immagine se presente
if (!empty($data['img_url'])) {
    $stmt = $conn->prepare("
        INSERT INTO immagini (URL, Descrizione, ID_Film)
        VALUES (?, 'Poster', ?)
    ");
    $stmt->bind_param("si", $data['img_url'], $film_id);
    $stmt->execute();
}

$_SESSION['message'] = "Film creato con successo!";
header("Location: ../../public/dashboard.php");
exit;
