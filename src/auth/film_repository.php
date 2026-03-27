<?php
require_once __DIR__ . '/../database/php.conndatabase.php';

class FilmRepository {

    // READ: tutti i film
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

    // READ: singolo film
    public static function getFilmById($id) {
        global $conn;

        $stmt = $conn->prepare("
            SELECT f.ID_Film, f.Titolo, f.Anno, f.Durata, f.Trama,
                   i.URL AS poster
            FROM film f
            LEFT JOIN immagini i ON f.ID_Film = i.ID_Film
            WHERE f.ID_Film = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // CREATE
    public static function createFilm($data) {
        global $conn;

        $stmt = $conn->prepare("
            INSERT INTO film (Titolo, Anno, Durata, Trama)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "siss",
            $data['titolo'],
            $data['anno'],
            $data['durata'],
            $data['trama']
        );

        return $stmt->execute();
    }

    // UPDATE
    public static function updateFilm($data) {
        global $conn;

        $stmt = $conn->prepare("
            UPDATE film
            SET Titolo = ?, Anno = ?, Durata = ?, Trama = ?
            WHERE ID_Film = ?
        ");
        $stmt->bind_param(
            "sissi",
            $data['titolo'],
            $data['anno'],
            $data['durata'],
            $data['trama'],
            $data['id']
        );

        return $stmt->execute();
    }

    // DELETE
    public static function deleteFilm($id) {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM film WHERE ID_Film = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
