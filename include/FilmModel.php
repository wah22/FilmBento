<?php

class FilmModel {

    function getFilm($by, $value) {
        $film = new Film();
        
        if ($by == 'id') {
            if ($value == 0) {
                return false;
            }
            $stmt = DB::getInstance()->prepare('SELECT * FROM fr_films WHERE id = :value');
        } else if ($by == 'title') {
            $stmt = DB::getInstance()->prepare('SELECT * FROM fr_films WHERE title = :value');
        } else {
            throw new Exception('Paramaters must be id or title');
        }

        $stmt->bindParam(':value', $value);
        $stmt->execute();
        if (!$stmt->rowCount()) {
            return false;
        }
        $row = $stmt->fetch();

        $film->setID($row['id']);
        $film->setTitle($row['title']);

        $stmt = DB::getInstance()->prepare('SELECT user_id, rating, UNIX_TIMESTAMP(date) as date FROM fr_seens WHERE film_id = :id');
        $id = $film->getID();
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $userID = $row['user_id'];
            $rating = $row['rating'];
            $date = $row['date'];
            $seen = new Seen($userID, $id, $rating, $date);
            $film->addToSeens($seen);
        }

        return $film;
    }

    function getAllFilms() {
        $films = array();

        $stmt = DB::getInstance()->prepare('SELECT id FROM fr_films');
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $films[] = $this->getFilm('id', $row['id']);
        }
        
        return $films;
    }

    function save($film) {
        // if film already exists
        if ($this->filmExists($film)) {
            //$stmt = DB::getInstance()->prepare('UPDATE fr_films SET xxx WHERE title = :title');
            //$stmt->bindParam(':title', $title);
            //$stmt->execute();
        } else {
            // save new film to db
            $stmt = DB::getInstance()->prepare('INSERT INTO fr_films VALUES (NULL, :title)');
            $title = $film->getTitle();
            $stmt->bindParam(':title', $title);
            $stmt->execute();
        }
    }

    function filmExists($film) {
        $title = $film->getTitle();
        $stmt = DB::getInstance()->prepare('SELECT * FROM fr_films WHERE title = :title ');
        $stmt->bindParam(':title', $title);
        $stmt->execute();
        if ($stmt->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * returns an array of $films matching a query
     */
    function search($query) {
        $search = DB::getInstance()->prepare('SELECT id FROM fr_films WHERE title LIKE :query ORDER BY title');
        $q = "%$query%";
        $search->bindParam(':query', $q);
        $search->execute();

        $results = array();
        while ($row = $search->fetch()) {
            $results[] = $this->getFilm('id', $row['id']);
        }
        return $results;
    }

    function searchSeens($userID, $query) {
        $search = DB::getInstance()->prepare('SELECT film_id FROM fr_seens, fr_films
                                            WHERE fr_seens.film_id = fr_films.id && fr_films.title LIKE :query && user_id = :user_id
                                            ORDER BY title');
        $q = "%$query%";
        $search->bindParam(':query', $q);
        $search->bindParam(':user_id', $userID);
        $search->execute();

        $results = array();
        while ($row = $search->fetch()) {
            $results[] = $this->getFilm('id', $row['film_id']);
        }
        return $results;
    }
}
