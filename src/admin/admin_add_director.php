<?php
require_once __DIR__ . '/../database/php.conndatabase.php';

if (
    !isset($_SESSION['user']) ||
    !isset($_SESSION['user']['ID_Utente']) ||
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
        try {
            $stmt = $pdo->prepare("INSERT INTO Registi (Nome, Cognome, Data_Nascita) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $cognome, $data_nascita]);
            $_SESSION['message'] = 'Regista "' . htmlspecialchars($nome . ' ' . $cognome) . '" aggiunto con successo.';
            header('Location: ../../public/dashboard.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Errore durante l\'inserimento: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Nuovo Regista</title>
    <link rel="stylesheet" href="../template/pages/admin_style.css">
</head>
<body>
    <div class="admin-container" style="max-width: 600px;">
        <div class="create-film-card">
            <h2>Aggiungi Nuovo Regista</h2>
            <?php if ($error): ?>
                <div class="message" style="background:#cc0000;"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST" class="film-form">
                <div class="form-group">
                    <label>Nome *</label>
                    <input type="text" name="nome" required value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label>Cognome *</label>
                    <input type="text" name="cognome" required value="<?php echo isset($_POST['cognome']) ? htmlspecialchars($_POST['cognome']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label>Data di nascita (opzionale)</label>
                    <input type="date" name="data_nascita" value="<?php echo isset($_POST['data_nascita']) ? htmlspecialchars($_POST['data_nascita']) : ''; ?>">
                </div>
                <button type="submit" class="btn-create">Salva Regista</button>
                <a href="dashboard_admin.php" class="small-link" style="display:block; margin-top:15px;">← Torna alla gestione film</a>
            </form>
        </div>
    </div>
</body>
</html>