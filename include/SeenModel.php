<?php

class SeenModel {

    function getSeen($user, $film) {
        $stmt = DB::getInstance()->prepare('SELECT film_id, rating, tweeview, UNIX_TIMESTAMP(date) as date
                                  FROM fr_seens
                                  WHERE user_id = :user_id && film_id = :film_id');
        $userID = $user->getID();
        $filmID = $film->getID();
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':film_id', $filmID);
        $stmt->execute();

        if (!$stmt->rowcount()) {
            return false;
        }

        $row = $stmt->fetch();
        $rating = $row['rating'];
        $date = $row['date'];
        $tweeview = $row['tweeview'];

        $seen = new Seen($userID, $filmID, $rating, $date, $tweeview);
        return $seen;
    }

    function getLastSeens ($numToGet, $user, $offset = 0) {
        $stmt = DB::getInstance()->prepare('SELECT film_id, rating, UNIX_TIMESTAMP(date) as date
                                          FROM fr_seens
                                          WHERE user_id = :user_id
                                          ORDER BY date DESC
                                          LIMIT :offset, :num_to_get');
        $id = $user->getID();
        $stmt->bindParam(':user_id', $id);

        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT); // casting necessary here due to php bug
        $stmt->bindParam(':num_to_get', $numToGet, PDO::PARAM_INT); // casting necessary here due to php bug

        $stmt->execute();
        $seens = array();
        while ($row = $stmt->fetch()) {
            $filmID = $row['film_id'];
            $rating = $row['rating'];
            $date = $row['date'];
            $seen = new Seen($id, $filmID, $rating, $date);
            $seens[] = $seen;
        }
        return $seens;
    }

    function getNumFilmsSeen($user) {
        $id = $user->getID();
        $stmt = DB::getInstance()->prepare('SELECT *
                                  FROM fr_seens
                                  WHERE user_id = :user_id');
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();
        $numSeen = $stmt->rowCount();

        return $numSeen;
    }

    function getFilmsLastSeens ($numToGet, $film) {
        $stmt = DB::getInstance()->prepare('SELECT user_id, rating, UNIX_TIMESTAMP(date) as date
                                          FROM fr_seens
                                          WHERE film_id = :film_id
                                          ORDER BY date DESC
                                          LIMIT :num_to_get');
        $filmID = $film->getID();
        $stmt->bindParam(':film_id', $filmID);

        $stmt->bindParam(':num_to_get', $numToGet, PDO::PARAM_INT); // casting necessary here due to php bug

        $stmt->execute();
        
        $seens = array();
        while ($row = $stmt->fetch()) {
            $userID = $row['user_id'];
            $rating = $row['rating'];
            $date = $row['date'];
            $seen = new Seen($userID, $filmID, $rating, $date);
            $seens[] = $seen;
        }
        return $seens;
    }

    function userHasSeen($user, $film) {
        $stmt = DB::getInstance()->prepare('SELECT * FROM fr_seens WHERE user_id = :user_id && film_id = :film_id');

        $userID = $user->getID();
        $filmID = $film->getID();
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':film_id', $filmID);

        $stmt->execute();

        if ($stmt->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    function userHasRated($user, $film) {
        $stmt = DB::getInstance()->prepare('SELECT rating FROM fr_seens WHERE user_id = :user_id && film_id = :film_id');
        $userID = $user->getID();
        $filmID = $film->getID();
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':film_id', $filmID);
        $stmt->execute();

        if (!$stmt->rowCount()) {
            return false;
        } else {
            $row = $stmt->fetch();
            if ($row['rating']) {
                return true;
            } else {
                return false;
            }
        }
    }

    function create($seen) {
        $userID = $seen->getUserID();
        $filmID = $seen->getFilmID();
        $rating = $seen->getRating();
        $date = $seen->getDate();
        $tweeview = $seen->getTweeview();
        $stmt = DB::getInstance()->prepare('INSERT INTO fr_seens VALUES (NULL, :user_id, :film_id, :rating, :tweeview, FROM_UNIXTIME(:date) )');
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':film_id', $filmID);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':tweeview', $tweeview);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
    }

    function save($seen) {
        $stmt = DB::getInstance()->prepare('UPDATE fr_seens SET rating = :rating, tweeview = :tweeview WHERE user_id = :user_id && film_id = :film_id');
        $userID = $seen->getUserID();
        $filmID = $seen->getFilmID();
        $rating = $seen->getRating();
        $tweeview = $seen->getTweeview();
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':film_id', $filmID);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':tweeview', $tweeview);
        $stmt->execute();
    }

    function delete($seen) {
        $stmt = DB::getInstance()->prepare('DELETE FROM fr_seens WHERE user_id = :user_id && film_id = :film_id');
        $userID = $seen->getUserID();
        $filmID = $seen->getFilmID();
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':film_id', $filmID);
        $stmt->execute();
    }
}
