<?php
// src/auth/FilmRepository.php

require_once __DIR__ . '/config.php';

class FilmRepository {

    public static function getAllFilms() {
        global $conn;

        $sql = "SELECT titolo, immagine FROM film";
        $result = $conn->query($sql);

        $films = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $films[] = $row;
            }
        }

        return $films;
    }
}
