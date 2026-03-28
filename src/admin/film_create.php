<?php
require_once '../database/php.conndatabase.php';

if (!isset($_SESSION['user_id']) || $_SESSION['admin'] !== 1) {
    header('Location: ../../public/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titolo = trim($_POST['titolo'] ?? '');
    $anno = (int)($_POST['anno'] ?? 0);
    $durata = !empty($_POST['durata']) ? (int)$_POST['durata'] : null;
    $trama = trim($_POST['trama'] ?? '');
    $regista_id = (int)($_POST['regista_id'] ?? 0);

    if (empty($titolo) || $anno < 1900 || $anno > 2026 || $regista_id <= 0) {
        $_SESSION['message'] = 'Errore: dati non validi per la creazione del film.';
        header('Location: dashboard_admin.php');
        exit;
    }

    $stmt = $pdo->prepare("SELECT ID_Regista FROM Registi WHERE ID_Regista = ?");
    $stmt->execute([$regista_id]);
    if (!$stmt->fetch()) {
        $_SESSION['message'] = 'Regista non valido.';
        header('Location: dashboard_admin.php');
        exit;
    }

    $insert = $pdo->prepare("INSERT INTO Film (Titolo, Anno, Durata, Trama, ID_Regista) VALUES (?, ?, ?, ?, ?)");
    $insert->execute([$titolo, $anno, $durata, $trama, $regista_id]);

    $_SESSION['message'] = 'Film "' . htmlspecialchars($titolo) . '" creato con successo.';
    header('Location: dashboard_admin.php');
    exit;
} else {
    header('Location: dashboard_admin.php');
    exit;
}
?>