<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['ID_Utente'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorizzato']);
    exit;
}

// Dati di connessione (MODIFICA CON I TUOI)
// one sec
$host = 'localhost';
$dbname = 'nome_database';
$username_db = 'root';
$password_db = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username_db, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $nuovaPassword = $_POST['password'] ?? '';

    
    if (empty($username) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Tutti i campi sono obbligatori']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Email non valida']);
        exit;
    }
    if (strlen($username) > 30) {
        echo json_encode(['success' => false, 'message' => 'Username troppo lungo (max 30 caratteri)']);
        exit;
    }

    // Verifica se l'email è già usata da un altro utente
    $stmt = $pdo->prepare("SELECT ID_Utente FROM utenti WHERE Email = ? AND ID_Utente != ?");
    $stmt->execute([$email, $_SESSION['ID_Utente']]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Email già utilizzata da un altro account']);
        exit;
    }

    
    $avatarPath = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/avatars/';
        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileInfo = pathinfo($_FILES['avatar']['name']);
        $extension = strtolower($fileInfo['extension']);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($extension, $allowedExtensions)) {
            // Limite dimensione (es. 2MB)
            if ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
                echo json_encode(['success' => false, 'message' => 'L\'immagine non deve superare i 2MB']);
                exit;
            }

           
            $filename = 'avatar_' . $_SESSION['ID_Utente'] . '_' . time() . '.' . $extension;
            $filepath = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $filepath)) {
                $avatarPath = $filepath;
            } else {
                echo json_encode(['success' => false, 'message' => 'Errore nel salvare l\'immagine']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Tipo file non supportato. Usa JPG, PNG, GIF o WEBP']);
            exit;
        }
    }

   
    if (!empty($nuovaPassword)) {
        $passwordHash = password_hash($nuovaPassword, PASSWORD_DEFAULT);
        if ($avatarPath) {
            $sql = "UPDATE utenti SET Username = ?, Email = ?, Password = ?, Avatar = ? WHERE ID_Utente = ?";
            $params = [$username, $email, $passwordHash, $avatarPath, $_SESSION['ID_Utente']];
        } else {
            $sql = "UPDATE utenti SET Username = ?, Email = ?, Password = ? WHERE ID_Utente = ?";
            $params = [$username, $email, $passwordHash, $_SESSION['ID_Utente']];
        }
    } else {
        if ($avatarPath) {
            $sql = "UPDATE utenti SET Username = ?, Email = ?, Avatar = ? WHERE ID_Utente = ?";
            $params = [$username, $email, $avatarPath, $_SESSION['ID_Utente']];
        } else {
            $sql = "UPDATE utenti SET Username = ?, Email = ? WHERE ID_Utente = ?";
            $params = [$username, $email, $_SESSION['ID_Utente']];
        }
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode(['success' => true, 'message' => 'Profilo aggiornato con successo']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Errore database: ' . $e->getMessage()]);
}
