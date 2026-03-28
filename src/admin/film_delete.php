<?php
require_once '../database/php.conndatabase.php';

if (!isset($_SESSION['user_id']) || $_SESSION['admin'] !== 1) {
    header('Location: ../../public/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $film_id = (int)($_POST['film_id'] ?? 0);

    if ($film_id <= 0) {
        $_SESSION['message'] = 'ID film non valido.';
        header('Location: dashboard_admin.php');
        exit;
    }

    $check = $pdo->prepare("SELECT Titolo FROM Film WHERE ID_Film = ?");
    $check->execute([$film_id]);
    $film = $check->fetch(PDO::FETCH_ASSOC);

    if (!$film) {
        $_SESSION['message'] = 'Film non trovato.';
        header('Location: dashboard_admin.php');
        exit;
    }

    $delete = $pdo->prepare("DELETE FROM Film WHERE ID_Film = ?");
    $delete->execute([$film_id]);

    $_SESSION['message'] = 'Film "' . htmlspecialchars($film['Titolo']) . '" eliminato definitivamente.';
    header('Location: dashboard_admin.php');
    exit;
} else {
    header('Location: dashboard_admin.php');
    exit;
}
?>