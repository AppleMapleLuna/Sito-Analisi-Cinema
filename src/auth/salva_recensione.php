<?php
session_start();
require_once __DIR__ . '/../database/php.conndatabase.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../../public/login.php");
    exit;
}

$utente = $_SESSION['user']['ID_Utente'];
$film = $_POST['film_id'] ?? null;
$testo = trim($_POST['testo'] ?? '');
$voto = intval($_POST['voto'] ?? 0);

if (!$film || empty($testo) || $voto < 1 || $voto > 10) {
    die("Dati non validi.");
}

// Salva recensione
$stmt = $conn->prepare("INSERT INTO recensioni (Testo, Data, ID_Utente, ID_Film) VALUES (?, NOW(), ?, ?)");
$stmt->bind_param("sii", $testo, $utente, $film);
$stmt->execute();

// Salva voto
$stmt2 = $conn->prepare("INSERT INTO valutazioni (Voto, ID_Utente, ID_Film) VALUES (?, ?, ?)");
$stmt2->bind_param("iii", $voto, $utente, $film);
$stmt2->execute();

header("Location: ../../public/recensioni.php");
exit;
