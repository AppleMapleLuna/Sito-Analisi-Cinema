<h2>Gestione Film</h2>

<a href="/dashboard.php?page=film_create">Aggiungi nuovo film</a>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Titolo</th>
        <th>Anno</th>
        <th>Azioni</th>
    </tr>

    <?php
    require_once __DIR__ . '/../../src/auth/film_repository.php';
    $films = FilmRepository::getAllFilms();

    foreach ($films as $film):
    ?>
        <tr>
            <td><?= $film['ID_Film'] ?></td>
            <td><?= htmlspecialchars($film['Titolo']) ?></td>
            <td><?= $film['Anno'] ?></td>
            <td>
                <a href="/dashboard_admin.php?page=film_edit&id=<?= $film['ID_Film'] ?>">Modifica</a> |
                <a href="/dashboard_admin.php?page=film_delete&id=<?= $film['ID_Film'] ?>"
                   onclick="return confirm('Sei sicuro di voler eliminare questo film?')">
                   Elimina
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
