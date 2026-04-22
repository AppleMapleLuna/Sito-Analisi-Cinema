<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['admin'] !== 1) {
    header("Location: ../../public/login.php");
    exit;
}

require_once __DIR__ . '/../auth/film_repository.php';

$films = FilmRepository::getAllFilms();
?>

<h2>Gestione Film</h2>

<a href="film_create_form.php" class="btn-create">+ Aggiungi nuovo film</a>

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
                        <a href="film_edit.php?id=<?= $film['ID_film'] ?>" class="btn-edit">
                            Modifica
                        </a>

                        <!-- Elimina -->
                        <form action="film_delete.php" method="POST" class="delete-form"
                              onsubmit="return confirm('Sei sicuro di voler eliminare questo film?');">
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
