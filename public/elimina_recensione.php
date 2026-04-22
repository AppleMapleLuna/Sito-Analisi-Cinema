<?php
session_start();
require_once __DIR__ . '/../database/php.conndatabase.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$id_recensione = (int)($_POST['id_recensione'] ?? 0);
$redirect = $_POST['redirect'] ?? 'index.php';

if ($id_recensione <= 0) {
    header("Location: $redirect");
    exit;
}

$stmt = $conn->prepare("SELECT ID_Utente, ID_Film FROM recensioni WHERE ID_Recensione = ?");
$stmt->bind_param("i", $id_recensione);
$stmt->execute();
$rec = $stmt->get_result()->fetch_assoc();

if (!$rec) {
    header("Location: $redirect");
    exit;
}

$is_author = ($_SESSION['user']['ID_Utente'] == $rec['ID_Utente']);
$is_admin = ($_SESSION['user']['admin'] == 1);

if (!$is_author && !$is_admin) {
    header("Location: $redirect");
    exit;
}


$conn->begin_transaction();
try {
    $stmt_del_val = $conn->prepare("DELETE FROM valutazioni WHERE ID_Utente = ? AND ID_Film = ?");
    $stmt_del_val->bind_param("ii", $rec['ID_Utente'], $rec['ID_Film']);
    $stmt_del_val->execute();
    
    $stmt_del_rec = $conn->prepare("DELETE FROM recensioni WHERE ID_Recensione = ?");
    $stmt_del_rec->bind_param("i", $id_recensione);
    $stmt_del_rec->execute();
    
    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
}

header("Location: $redirect");
exit;