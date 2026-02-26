<?php
session_start();
require_once 'php.conndatabase.php';

// Recupera i dati dal form
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Redirect se i campi sono vuoti
if (empty($email) || empty($password)) {
    header('Location: index.html?error=' . urlencode('Inserisci email e password'));
    exit;
}

// Preparazione query con prepared statement
$sql = "SELECT ID_Utente, Username, Password FROM utenti WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Confronto password (in chiaro nell'esempio, ma in produzione usa password_verify())
    if ($password === $row['Password']) {
        // Login corretto: salva in sessione
        $_SESSION['user_id'] = $row['ID_Utente'];
        $_SESSION['username'] = $row['Username'];
        $_SESSION['email'] = $email;
        
        // Reindirizza a area riservata
        header('Location: dashboard.html');
        exit;
    }
}

// Se arriva qui, login fallito
header('Location: index.html?error=' . urlencode('Email o password errati'));
$stmt->close();
$conn->close();
exit;
?>