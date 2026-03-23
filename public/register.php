<?php
session_start();
$error = $_GET['e'] ?? '';
$ok = $_GET['ok'] ?? '';
?>
<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Registrazione</title>
    <link rel="stylesheet" href="../src/template/pages/style_login.css">
</head>
<body>
    <div class="card">
        <h2>REGISTRAZIONE</h2>

        <?php if ($error): ?>
            <div class="error">
                <?php
                    switch ($error) {
                        case '1':
                            echo "Errore: Compila tutti i campi.";
                            break;
                        case 'weak':
                            echo "Errore: La password non rispetta i requisiti di sicurezza. (Minimo 8 caratteri, almeno una parola maiuscola e in minuscola e un carattere speciale)";
                            break;
                        case 'email':
                            echo "Errore: L'email inserita non è valida.";
                            break;
                        case 'exists':
                            echo "Errore: Email o username già registrati.";
                            break;
                        case 'user':
                            echo "Errore: L'username deve contenere 3-20 caratteri alfanumerici o underscore.";
                            break;
                        default:
                            echo "Errore: Errore nella registrazione.";
                    }
                ?>
            </div>
        <?php endif; ?>


        <form method="post" action="../src/auth/register.php">
            <input name="email" type="email" placeholder="Email" required>
            <input name="username" placeholder="Username" required>
            <input 
                name="password" 
                type="password" 
                placeholder="Password" 
                required
                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}"
                title="La password deve contenere almeno 8 caratteri, una maiuscola, una minuscola, un numero e un simbolo."
            >
            <!--Ora chi deve mettere una password ne deve mettere una sicura-->
            <button>REGISTRATI</button>
        </form>

        <a href="login.php"><button>Vai al login</button></a>
    </div>
</body>
</html>
