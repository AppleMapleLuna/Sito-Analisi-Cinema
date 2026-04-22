<?php
session_start();
require_once __DIR__ . '/../database/php.conndatabase.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../../public/login.php");
    exit;
}

$id = $_POST['id'] ?? null;
$user = $_SESSION['user']['ID_Utente'];

if (!$id) die("ID recensione mancante");

// Controllo sicurezza: l’utente può eliminare SOLO le sue recensioni
$stmt = $conn->prepare("SELECT ID_Utente, ID_Film FROM recensioni WHERE ID_Recensione = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if (!$res || $res['ID_Utente'] != $user) {
    die("Non puoi eliminare questa recensione.");
}

// Elimina recensione
$conn->query("DELETE FROM recensioni WHERE ID_Recensione = $id");

// Elimina voto associato
$conn->query("DELETE FROM valutazioni WHERE ID_Utente = $user AND ID_Film = {$res['ID_Film']}");

header("Location: ../../public/recensioni.php");
exit;
