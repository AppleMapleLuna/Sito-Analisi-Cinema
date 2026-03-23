<?php
require_once __DIR__ . '/../database/php.conndatabase.php';

class FilmRepository {

    public static function getAllFilms() {
        global $conn;

        $sql = "
            SELECT f.ID_Film, f.Titolo, f.Anno, f.Durata, f.Trama,
                   i.URL AS poster
            FROM film f
            LEFT JOIN immagini i ON f.ID_Film = i.ID_Film
        ";

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
