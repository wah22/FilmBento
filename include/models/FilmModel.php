<?php

class FilmModel {
    function create($film) {
        $stmt = DB::getInstance()->prepare('INSERT INTO fbo_films VALUES (NULL, :title, :year, :added_by_user_id, NOW())');
        $title = $film->getTitle();
        $year = $film->getYear();
        $addedID = $film->getUserWhoAddedID();
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':added_by_user_id', $addedID);
        $stmt->execute();
    }

    function getFilm($by, $value, $year = 0) {
        $film = new Film();
        
        if ($by == 'id') {
            if ($value == 0) {
                return false;
            }
            $stmt = DB::getInstance()->prepare('SELECT * FROM fbo_films WHERE id = :value');
        } else if ($by == 'title') {
            if (!$year) {
                $stmt = DB::getInstance()->prepare('SELECT * FROM fbo_films WHERE title = :value');
            } else {
                $stmt = DB::getInstance()->prepare('SELECT * FROM fbo_films WHERE title = :value && year = :year');
                $stmt->bindParam(':year', $year);
            }
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
        $film->setYear($row['year']);
        $film->setUserWhoAddedID($row['added_by_user_id']);

        // load meta
        $stmt = DB::getInstance()->prepare('SELECT type, value FROM fbo_film_meta WHERE film_id = :film_id');
        $stmt->bindParam(':film_id', $row['id']);
        $stmt->execute();

        $meta = array();
        while ($row = $stmt->fetch()) {
            $film->setMeta($row['type'], $row['value']);
        }


        $stmt = DB::getInstance()->prepare('SELECT user_id, rating, UNIX_TIMESTAMP(date) as date FROM fbo_seens WHERE film_id = :id');
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

    function save($film) {
        $filmID = $film->getID();
        $year = $film->getYear();
        $stmt = DB::getInstance()->prepare('UPDATE fbo_films SET year = :year
                                            WHERE id = :film_id');
        $stmt->bindParam(':film_id', $filmID);
        $stmt->bindParam(':year', $year);
        $stmt->execute();

        // save meta
        $stmt = DB::getInstance()->prepare('UPDATE fbo_film_meta SET value = :value
                                            WHERE film_id = :film_id && type = :type');
        $stmt->bindParam(':film_id', $filmID);

        $check = DB::getInstance()->prepare('SELECT * FROM fbo_film_meta WHERE film_id = :film_id && type = :type');
        $check->bindParam(':film_id', $filmID);

        foreach ($film->getAllMeta() as $type=>$value) {
            $check->bindParam(':type', $type);
            $check->execute();
            if ($check->rowCount()) {
                $stmt->bindParam(':type', $type);
                $cleanValue = htmlentities($value, ENT_QUOTES, 'UTF-8');
                $stmt->bindParam(':value', $cleanValue);
                $stmt->execute();
            } else {
                $insert = DB::getInstance()->prepare('INSERT INTO fbo_film_meta VALUES (NULL, :film_id, :type, :value)');
                $insert->bindParam(':film_id', $filmID);
                $insert->bindParam(':type', $type);
                $cleanValue = htmlentities($value, ENT_QUOTES, 'UTF-8');
                $insert->bindParam(':value', $value);
                $insert->execute();
            }
        }
    }

    function getAllFilms() {
        $films = array();

        $stmt = DB::getInstance()->prepare('SELECT id FROM fbo_films');
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $films[] = $this->getFilm('id', $row['id']);
        }
        
        return $films;
    }

    function filmExists($film) {
        $title = $film->getTitle();
        $stmt = DB::getInstance()->prepare('SELECT * FROM fbo_films WHERE title = :title ');
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
        $search = DB::getInstance()->prepare('SELECT id FROM fbo_films WHERE title LIKE :query ORDER BY title');
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
        $search = DB::getInstance()->prepare('SELECT film_id FROM fbo_seens, fbo_films
                                            WHERE fbo_seens.film_id = fbo_films.id && fbo_films.title LIKE :query && user_id = :user_id
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

    function getRecentlyAdded($numToGet = 10) {
        $stmt = DB::getInstance()->prepare("SELECT * FROM fbo_films ORDER BY when_added DESC LIMIT $numToGet");
        $stmt->execute();
        $films = array();
        while ($row = $stmt->fetch()) {
            $films[] = $this->getFilm('id', $row['id']);
        }
        return $films;
    }
}
