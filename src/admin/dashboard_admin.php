<?php
// Questo file viene incluso da public/dashboard.php
// quindi la sessione è già avviata e l'utente è già verificato
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Amministratore</title>
</head>
<body>

    <h1>Dashboard Amministratore</h1>

    <a href="/logout.php" style="color: red; font-weight: bold;">Logout</a>

    <ul>
        <li><a href="/dashboard.php?page=film">Gestione Film</a></li>
        <li><a href="/dashboard.php?page=immagini">Gestione Immagini</a></li>
        <li><a href="/dashboard.php?page=utenti">Gestione Utenti</a></li>
        <li><a href="/dashboard.php?page=recensioni">Gestione Recensioni</a></li>
    </ul>

    <?php
        // Router interno dell'admin
        $page = $_GET['page'] ?? null;

        switch ($page) {
            case 'film':
                include __DIR__ . '/film_list.php';
                break;

            case 'immagini':
                include __DIR__ . '/immagini_list.php';
                break;

            case 'utenti':
                include __DIR__ . '/utenti_list.php';
                break;

            case 'recensioni':
                include __DIR__ . '/recensioni_list.php';
                break;

            default:
                echo "<p>Benvenuto nella dashboard amministratore.</p>";
        }
    ?>

</body>
</html>
