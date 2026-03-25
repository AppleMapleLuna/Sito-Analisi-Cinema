<?php
require_once '../database/php.conndatabase.php';
if (!isset($_SESSION['ID_Utente'])) {
    header('Location: ../../public/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Cambia password</title>
    <link rel="stylesheet" href="../src/template/page/style_gestione_profilo.css">
</head>
<body>
    <div class="container">
        <div class="profile-card">
            <h1>Cambia password</h1>
            <form id="cambia-password-form">
                <div class="form-group">
                    <label for="old-password">Password attuale</label>
                    <input type="password" id="old-password" required>
                </div>
                <div class="form-group">
                    <label for="new-password">Nuova password</label>
                    <input type="password" id="new-password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Conferma nuova password</label>
                    <input type="password" id="confirm-password" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-save">Aggiorna password</button>
                    <a href="profilo.php" class="btn-cancel">Annulla</a>
                </div>
            </form>
            <div id="message" class="message"></div>
        </div>
    </div>
    <script src="cambia_password.js"></script>
</body>
</html>