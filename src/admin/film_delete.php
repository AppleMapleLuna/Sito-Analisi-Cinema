<?php
session_start();

if (
    !isset($_SESSION['user']) ||
    $_SESSION['user']['admin'] !== 1
) {
    header('Location: ../../public/login.php');
    exit;
}

require_once __DIR__ . '/../database/php.conndatabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $film_id = (int)($_POST['film_id'] ?? 0);

    if ($film_id <= 0) {
        $_SESSION['message'] = 'ID film non valido.';
        header('Location: ../../public/dashboard.php');
        exit;
    }

    // Controllo esistenza film
    $check = $conn->prepare("SELECT Titolo FROM film WHERE ID_film = ?");
    $check->bind_param("i", $film_id);
    $check->execute();
    $result = $check->get_result();
    $film = $result->fetch_assoc();

    if (!$film) {
        $_SESSION['message'] = 'Film non trovato.';
        header('Location: ../../public/dashboard.php');
        exit;
    }

    // Eliminazione
    $delete = $conn->prepare("DELETE FROM film WHERE ID_film = ?");
    $delete->bind_param("i", $film_id);
    $delete->execute();

    $_SESSION['message'] = 'Film "' . htmlspecialchars($film['Titolo']) . '" eliminato.';
    header('Location: ../../public/dashboard.php');
    exit;

} else {
    header('Location: ../../public/dashboard.php');
    exit;
}
