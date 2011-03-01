<?php

class FilmModel {

    function getFilm($id) {
        $film = new Film();

        $stmt = DB::getInstance()->prepare('SELECT * FROM fr_films WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();

        $film->setID($row['id']);
        $film->setTitle($row['title']);

        return $film;
    }
}