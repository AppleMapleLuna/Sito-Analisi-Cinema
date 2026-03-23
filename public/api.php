<?php
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['ID_Utente'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorizzato']);
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'get_profilo':
        $stmt = $pdo->prepare("SELECT Username, Email, Avatar FROM utenti WHERE ID_Utente = ?");
        $stmt->execute([$_SESSION['ID_Utente']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'user' => $user]);
        break;

    case 'update_username':
        $username = $_POST['username'] ?? '';
        if (empty($username) || strlen($username) > 30) {
            echo json_encode(['success' => false, 'message' => 'Dati non validi']);
            exit;
        }
        $stmt = $pdo->prepare("UPDATE utenti SET Username = ? WHERE ID_Utente = ?");
        $stmt->execute([$username, $_SESSION['ID_Utente']]);
        echo json_encode(['success' => true]);
        break;

    case 'update_email':
        $email = $_POST['email'] ?? '';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Email non valida']);
            exit;
        }
        $check = $pdo->prepare("SELECT ID_Utente FROM utenti WHERE Email = ? AND ID_Utente != ?");
        $check->execute([$email, $_SESSION['ID_Utente']]);
        if ($check->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email già utilizzata']);
            exit;
        }
        $stmt = $pdo->prepare("UPDATE utenti SET Email = ? WHERE ID_Utente = ?");
        $stmt->execute([$email, $_SESSION['ID_Utente']]);
        echo json_encode(['success' => true]);
        break;

    case 'update_avatar':
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'Errore upload']);
            exit;
        }
        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($ext, $allowed) || $_FILES['avatar']['size'] > 2 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'File non valido']);
            exit;
        }
        $uploadDir = 'uploads/avatars/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        $filename = 'avatar_' . $_SESSION['ID_Utente'] . '_' . time() . '.' . $ext;
        $filepath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $filepath)) {
            $stmt = $pdo->prepare("UPDATE utenti SET Avatar = ? WHERE ID_Utente = ?");
            $stmt->execute([$filepath, $_SESSION['ID_Utente']]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore salvataggio']);
        }
        break;

    case 'cambia_password':
        $old = $_POST['old_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        if (empty($old) || empty($new) || strlen($new) < 6) {
            echo json_encode(['success' => false, 'message' => 'Dati non validi']);
            exit;
        }
        $stmt = $pdo->prepare("SELECT Password FROM utenti WHERE ID_Utente = ?");
        $stmt->execute([$_SESSION['ID_Utente']]);
        $user = $stmt->fetch();
        if (!password_verify($old, $user['Password'])) {
            echo json_encode(['success' => false, 'message' => 'Password attuale errata']);
            exit;
        }
        $newHash = password_hash($new, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE utenti SET Password = ? WHERE ID_Utente = ?");
        $update->execute([$newHash, $_SESSION['ID_Utente']]);
        echo json_encode(['success' => true]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Azione non valida']);
}
?>