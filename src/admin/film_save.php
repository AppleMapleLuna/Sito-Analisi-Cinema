<?php
require_once __DIR__ . '/../../src/auth/FilmRepository.php';

if (!empty($_POST['id'])) {
    FilmRepository::updateFilm($_POST);
} else {
    FilmRepository::createFilm($_POST);
}

header("Location: /dashboard.php?page=film");
exit;
