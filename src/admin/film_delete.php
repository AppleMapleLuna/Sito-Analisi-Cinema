<?php
require_once __DIR__ . '/../../src/auth/film_repository.php';

FilmRepository::deleteFilm($_GET['id']);

header("Location: /dashboard.php?page=film");
exit;
