<?php
require_once '../database/php.conndatabase.php';
require_once 'send_mail.php';

$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';


// Controlla se ci sono campi vuoti
if (empty($email) || empty($username) || empty($password)) {
    header("Location: ../../public/register.php?e=1");
    exit;
}

// Sicurezza password giusto in caso
if (!preg_match($pattern, $password)) {
    header("Location: ../../public/register.php?e=weak");
    exit;
}

// controlla se il formato è giusto
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../../public/register.php?e=email");
    exit;
}

// Controlla se esiste l'email
$check = $conn->prepare("SELECT ID FROM utenti WHERE Email = ? OR Username = ?");
$check->bind_param("ss", $email, $username);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    header("Location: ../../public/register.php?e=exists");
    exit;
}

// Controlla se l'username sia idonea.
if (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $username)) {
    header("Location: ../../public/register.php?e=user");
    exit;
}

// Inserimento + Password hashata
$hashed = password_hash($password, PASSWORD_DEFAULT);
$token = bin2hex(random_bytes(16));

$sql = "INSERT INTO utenti (Email, Username, Password, TokenVerifica, Verificato)
        VALUES (?, ?, ?, ?, 0)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $email, $username, $hashed, $token);

if ($stmt->execute()) {
    sendVerificationEmail($email, $token);
    header("Location: ../../public/register.php?ok=1");
    exit;
}

header("Location: ../../public/register.php?e=1");

$check->close();
$stmt->close();
$conn->close();

exit;
