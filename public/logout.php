<?php
session_start();

// 1. Svuota tutte le variabili di sessione
$_SESSION = [];

// 2. Cancella il cookie della sessione (se esiste)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Distruggi la sessione
session_destroy();

// 4. Redirect
header("Location: index.html");
exit;
