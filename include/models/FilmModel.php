<?php

/**
* FilmModel
* This model handels creating, reading, updating and deleting films from the database.
*/
class FilmModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    // Inserts a film into the database
    public function create($film) {
        $title = $film->getTitle();
        $year = $film->getYear();
        $addedID = $film->getUserWhoAddedID();
        $stmt = $this->pdo->prepare('INSERT INTO fbo_films VALUES (NULL, :title, :year, :added_by_user_id, NOW())');
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':added_by_user_id', $addedID);
        $stmt->execute();
    }

    // Gets and returns a film by id, title and/or year
    function getFilm($by, $value, $year = 0) {
        $film = new Film();
        
        if ($by == 'id') {
            $stmt = $this->pdo->prepare('SELECT * FROM fbo_films WHERE id = :value');
        } else if ($by == 'title') {
            if (!$year) {
                $stmt = $this->pdo->prepare('SELECT * FROM fbo_films WHERE title = :value');
            } else {
                $stmt = $this->pdo->prepare('SELECT * FROM fbo_films WHERE title = :value && year = :year');
                $stmt->bindParam(':year', $year);
            }
        } else {
            throw new Exception('Paramaters must be id or title');
        }

        $stmt->bindParam(':value', $value);
        $stmt->execute();

        // Return false if the film wasn't found
        if (!$stmt->rowCount()) {
            return false;
        }

        $filmRow = $stmt->fetch();

        $getMeta = $this->pdo->prepare('SELECT type, value FROM fbo_film_meta WHERE film_id = :film_id');
        $getMeta->bindParam(':film_id', $filmRow['id']);
        $getMeta->execute();

        $meta = $getMeta->fetchAll();

        $film = $this->load($filmRow, $meta);

        return $film;
    }

    // Returns all films in the database.
    // NB:: This is probably quite slow as it calls getFilm() for each one,
    // repeating the database query
    public function getAllFilms() {
        $films = array();

        $stmt = $this->pdo->prepare('SELECT id FROM fbo_films ORDER BY title');
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $films[] = $this->getFilm('id', $row['id']);
        }
        
        return $films;
    }

    // Get an array of the films that have been recently added to the database
    function getRecentlyAdded($numToGet = 10) {
        $stmt = $this->pdo->prepare("SELECT * FROM fbo_films ORDER BY when_added DESC LIMIT $numToGet");
        $stmt->execute();
        $films = array();
        while ($row = $stmt->fetch()) {
            $films[] = $this->getFilm('id', $row['id']);
        }
        return $films;
    }

    // Checks if a film exists on the database
    public function filmExists($film) {
        $id = $film->getID();
        $stmt = $this->pdo->prepare('SELECT * FROM fbo_films WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    // Returns on array of films that match the search query
    function search($query) {
        $search = $this->pdo->prepare('SELECT id FROM fbo_films WHERE title LIKE :query ORDER BY title');
        $q = "%$query%";
        $search->bindParam(':query', $q);
        $search->execute();

        $results = array();
        while ($row = $search->fetch()) {
            $results[] = $this->getFilm('id', $row['id']);
        }
        return $results;
    }

    // Updates a films record on the database
    public function save($film) {
        $filmID = $film->getID();
        $year = $film->getYear();
        $stmt = $this->pdo->prepare('UPDATE fbo_films
                                     SET year = :year
                                     WHERE id = :film_id');
        $stmt->bindParam(':film_id', $filmID);
        $stmt->bindParam(':year', $year);
        $stmt->execute();

        // save meta
        $stmt = $this->pdo->prepare('UPDATE fbo_film_meta
                                            SET value = :value
                                            WHERE film_id = :film_id && type = :type');
        $stmt->bindParam(':film_id', $filmID);

        $check = $this->pdo->prepare('SELECT * FROM fbo_film_meta
                                             WHERE film_id = :film_id && type = :type');
        $check->bindParam(':film_id', $filmID);

        foreach ($film->getAllMeta() as $type=>$value) {
            $check->bindParam(':type', $type);
            $check->execute();
            if ($check->rowCount()) {
                $stmt->bindParam(':type', $type);
                $stmt->bindParam(':value', $value);
                $stmt->execute();
            } else {
                $insert = $this->pdo->prepare('INSERT INTO fbo_film_meta
                                               VALUES (NULL, :film_id, :type, :value)');
                $insert->bindParam(':film_id', $filmID);
                $insert->bindParam(':type', $type);
                $insert->bindParam(':value', $value);
                $insert->execute();
            }
        }
    }

    // Deletes a film record and its meta records from the database
    public function delete($film) {
        $filmID = $film->getID();
        $delete = $this->pdo->prepare('DELETE FROM fbo_films WHERE id = :film_id');
        $delete->bindParam(':film_id', $filmID);
        $delete->execute();

        $deleteMeta = $this->pdo->prepare('DELETE FROM fbo_film_meta WHERE film_id = :film_id');
        $deleteMeta->bindParam(':film_id', $filmID);
        $deleteMeta->execute();
    }

    // Initiates a film object from the data passed to it
    private function load($filmRow, $meta = array()) {
        $film = new Film();

        $film->setID($filmRow['id']);
        $film->setTitle($filmRow['title']);
        $film->setYear($filmRow['year']);
        $film->setUserWhoAddedID($filmRow['added_by_user_id']);

        foreach ($meta as $entry) {
            $film->setMeta($entry['type'], $entry['value']);
        }

        return $film;
    }
}

