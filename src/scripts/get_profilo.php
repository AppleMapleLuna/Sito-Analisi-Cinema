<?php
session_start();
header('Content-Type: application/json');


if (!isset($_SESSION['ID_Utente'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorizzato']);
    exit;
}

// Dati di connessione (MODIFICA CON I TUOI)
// Ok, ci aggiungerò dopo
$host = 'localhost';
$dbname = 'nome_database';
$username_db = 'root';
$password_db = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username_db, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Se la tabella si chiama "utenti", altrimenti modifica
    $stmt = $pdo->prepare("SELECT ID_Utente, Username, Email, Avatar FROM utenti WHERE ID_Utente = ?");
    $stmt->execute([$_SESSION['ID_Utente']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(['success' => true, 'user' => $user]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Utente non trovato']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Errore database: ' . $e->getMessage()]);
}
?>