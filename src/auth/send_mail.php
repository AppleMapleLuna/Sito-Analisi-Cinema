<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../lib/PHPMailer/src/Exception.php';
require_once '../lib/PHPMailer/src/PHPMailer.php';
require_once '../lib/PHPMailer/src/SMTP.php';

function sendVerificationEmail($email, $token) {
    $mail = new PHPMailer(true);

    try {
        // Configurazione SMTP Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // QUI metti la tua email Gmail
        $mail->Username = 'gingengtea@gmail.com';

        // QUI metti la tua App Password
        $mail->Password = 'oddd dfzo vpnl xvto';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Mittente
        $mail->setFrom('gingengtea@gmail.com', 'Cinema App');

        // Destinatario
        $mail->addAddress($email);

        // Contenuto
        $mail->isHTML(true);
        $mail->Subject = 'Conferma la tua registrazione';

        $link = "http://localhost/SITO-ANALISI-CINEMA/public/verify.php?token=$token";

        $mail->Body = "
            Ciao!<br><br>
            Grazie per esserti registrato.<br>
            Per attivare il tuo account, clicca sul link qui sotto:<br><br>
            <a href='$link'>Verifica il tuo account</a><br><br>
            Se non hai richiesto tu la registrazione, ignora questa email.
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}
