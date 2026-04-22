<?php
session_start();
require_once __DIR__ . '/../database/php.conndatabase.php';

// Controllo accesso admin
if (
    !isset($_SESSION['user']) ||
    $_SESSION['user']['admin'] !== 1
) {
    header('Location: ../../public/login.php');
    exit;
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $cognome = trim($_POST['cognome'] ?? '');
    $data_nascita = !empty($_POST['data_nascita']) ? $_POST['data_nascita'] : null;

    if (empty($nome) || empty($cognome)) {
        $error = 'Nome e cognome sono obbligatori.';
    } else {
        $stmt = $conn->prepare("INSERT INTO registi (Nome, Cognome, Data_Nascita) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $cognome, $data_nascita);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Regista aggiunto con successo.";
            header("Location: ../../public/dashboard.php");
            exit;
        } else {
            $error = "Errore durante l'inserimento.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Nuovo Regista</title>
    <link rel="stylesheet" href="../template/admin_style.css">

</head>
<body>

<div class="admin-container" style="max-width: 600px;">
    <div class="create-film-card">
        <h2>Aggiungi Nuovo Regista</h2>

        <?php if ($error): ?>
            <div class="message" style="background:#cc0000;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="film-form">
            <div class="form-group">
                <label>Nome *</label>
                <input type="text" name="nome" required>
            </div>

            <div class="form-group">
                <label>Cognome *</label>
                <input type="text" name="cognome" required>
            </div>

            <div class="form-group">
                <label>Data di nascita (opzionale)</label>
                <input type="date" name="data_nascita">
            </div>

            <button type="submit" class="btn-create">Salva Regista</button>
            <a href="../../public/dashboard.php" class="small-link">← Torna alla gestione film</a>
        </form>
    </div>
</div>

</body>
</html>
