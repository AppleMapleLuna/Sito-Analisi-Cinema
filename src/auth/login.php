<?php
session_start();
require_once '../database/php.conndatabase.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header('Location: ../../public/login.php?e=1');
    exit;
}

$sql = "SELECT ID_Utente, Username, Password, Verificato FROM utenti WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    if ($row['Verificato'] == 0) {
        header('Location: ../../public/login.php?e=2'); // email non verificata
        exit;
    }

    if (password_verify($password, $row['Password'])) {
        $_SESSION['user'] = [
            'ID' => $row['ID_utente'],
            'Email' => $row['Email'],
            'Username' => $row['Username'],
            'admin' => (int)$row['admin']
        ];


        header('Location: ../../public/dashboard.php');
        exit;
    }
}

header('Location: ../../public/login.php?e=1');
exit;
