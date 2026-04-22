<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../database/php.conndatabase.php';

// Controllo admin
if (
    !isset($_SESSION['user']) ||
    $_SESSION['user']['admin'] !== 1
) {
    header('Location: ../../public/login.php');
    exit;
}

// Messaggi
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Query film
$result = $conn->query("
    SELECT f.ID_film, f.Titolo, f.Anno, f.Durata, f.Trama,
           r.Nome, r.Cognome
    FROM film f
    LEFT JOIN registi r ON f.ID_Regista = r.ID_Regista
    ORDER BY f.Anno DESC
");
$films = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Query registi
$result2 = $conn->query("SELECT ID_regista, Nome, Cognome FROM registi ORDER BY Cognome");
$directors = $result2 ? $result2->fetch_all(MYSQLI_ASSOC) : [];
?>

<div class="admin-container">

    <!-- HEADER -->
    <header class="admin-header">
        <h1>Area Amministratore</h1>
        <div class="user-info">
            <span>Ciao, <?= htmlspecialchars($_SESSION['user']['Username']) ?></span>
            <a href="../../public/logout.php" class="logout-btn">Logout</a>
        </div>
    </header>

    <!-- MESSAGGIO -->
    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="admin-grid">

        <!-- FORM CREAZIONE FILM -->
        <section class="create-film-card">
            <h2>Crea Nuovo film</h2>

            <form action="../src/admin/film_create.php" method="POST" class="film-form">

                <div class="form-group">
                    <label for="titolo">Titolo</label>
                    <input type="text" id="titolo" name="titolo" required>
                </div>

                <div class="form-group">
                    <label for="anno">Anno</label>
                    <input type="number" id="anno" name="anno" required min="1900" max="2026">
                </div>

                <div class="form-group">
                    <label for="durata">Durata (minuti)</label>
                    <input type="number" id="durata" name="durata">
                </div>

                <div class="form-group">
                    <label for="trama">Trama</label>
                    <textarea id="trama" name="trama" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="immagine">URL Immagine</label>
                    <input type="text" id="immagine" name="immagine_url" placeholder="URL immagine">
                </div>

                <div class="form-group">
                    <label for="regista">Regista</label>
                    <select id="regista" name="regista_id" required>
                        <option value="">Seleziona regista</option>
                        <?php foreach ($directors as $dir): ?>
                            <option value="<?= $dir['ID_regista'] ?>">
                                <?= htmlspecialchars($dir['Nome'] . ' ' . $dir['Cognome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <a href="../src/admin/admin_add_director.php" class="small-link">+ Nuovo regista</a>
                </div>

                <button type="submit" class="btn-create">Crea film</button>
            </form>
        </section>

        <!-- LISTA FILM -->
        <section class="films-list-card">
            <h2>Elenco film</h2>

            <div class="table-responsive">
                <table class="films-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titolo</th>
                            <th>Anno</th>
                            <th>Durata</th>
                            <th>Regista</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($films)): ?>
                            <?php foreach ($films as $film): ?>
                                <tr>
                                    <td><?= $film['ID_film'] ?></td>
                                    <td><?= htmlspecialchars($film['Titolo']) ?></td>
                                    <td><?= $film['Anno'] ?></td>
                                    <td><?= $film['Durata'] ? $film['Durata'] . ' min' : '-' ?></td>
                                    <td><?= htmlspecialchars($film['Nome'] . ' ' . $film['Cognome']) ?></td>

                                    <td class="actions">

                                        <!-- Modifica -->
                                        <a href="../src/admin/film_edit.php?id=<?= $film['ID_film'] ?>" class="btn-edit">
                                            Modifica
                                        </a>

                                        <!-- Elimina -->
                                        <form action="../src/admin/film_delete.php" method="POST" class="delete-form"
                                              onsubmit="return confirm('Eliminare questo film?');">
                                            <input type="hidden" name="film_id" value="<?= $film['ID_film'] ?>">
                                            <button type="submit" class="btn-delete">Elimina</button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6">Nessun film presente.</td></tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </section>

    </div>
</div>
