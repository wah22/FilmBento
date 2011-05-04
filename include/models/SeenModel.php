<?php

/** SeenModel
* Handles creating Seen objects from the database,
* and updating and deleting seen records from the database
*/
class SeenModel extends Model {

    public function  __construct() {
        parent::__construct();
    }

    // Inserts a Seen object into the database
    public function create($seen) {
        $userID   =   $seen->getUserID();
        $filmID   =   $seen->getFilmID();
        $rating   =   $seen->getRating();
        $date     =   $seen->getDate();
        $tweeview =   $seen->getTweeview();

        // If the seen already exists don't insert
        $check = $this->pdo->prepare('SELECT * FROM fbo_seens
                                      WHERE user_id = :user_id && film_id = :film_id');
        $check->bindParam(':user_id', $userID);
        $check->bindParam(':film_id', $filmID);
        $check->execute();
        if ($check->rowCount()) {
            return false;
        }

        $stmt = $this->pdo->prepare('INSERT INTO fbo_seens
                                     VALUES (NULL, :user_id, :film_id, :rating, :tweeview, FROM_UNIXTIME(:date))');
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':film_id', $filmID);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':tweeview', $tweeview);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
    }

    // Constructs a Seen object from the database and returns it
    public function getSeen($user, $film) {
        $userID = $user->getID();
        $filmID = $film->getID();
        $stmt = $this->pdo->prepare('SELECT user_id, film_id, rating, tweeview, UNIX_TIMESTAMP(date) as date
                                     FROM fbo_seens
                                     WHERE user_id = :user_id && film_id = :film_id');
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':film_id', $filmID);
        $stmt->execute();

        // Return false if the seen doesn't exist
        if (!$stmt->rowcount()) {
            return false;
        }

        $row = $stmt->fetch();

        $seen = $this->load($row);

        return $seen;
    }

    // Get last films seen by a user
    // $offset tells the query how many entries to skip (for listing multiple pages of films etc.)
    public function getLastSeens ($numToGet, $user, $offset = 0) {
        $id = $user->getID();
        $stmt = $this->pdo->prepare('SELECT user_id, film_id, rating, UNIX_TIMESTAMP(date) as date, tweeview
                                     FROM fbo_seens
                                     WHERE user_id = :user_id
                                     ORDER BY date DESC
                                     LIMIT :offset, :num_to_get');
        $stmt->bindParam(':user_id', $id);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT); // casting necessary here due to php bug
        $stmt->bindParam(':num_to_get', $numToGet, PDO::PARAM_INT); // casting necessary here due to php bug
        $stmt->execute();

        $seens = array();

        while ($row = $stmt->fetch()) {
            $seen = $this->load($row); 
            $seens[] = $seen;
        }

        return $seens;
    }

    // Get most recent seens of any film by any user
    public function getRecentSeens($numToGet = 10) {
        $get = $this->pdo->prepare('SELECT * FROM fbo_seens
                                    ORDER BY date desc
                                    LIMIT :num_to_get');
        $get->bindParam(':num_to_get', $numToGet, PDO::PARAM_INT);
        $get->execute();

        $seens = array();

        while ($row = $get->fetch()) {
            $seen = $this->load($row); 
            $seens[] = $seen;
        }

        return $seens;
    }


    // Querys the database and returns a users number of seens
    public function getNumFilmsSeen($user) {
        $id = $user->getID();
        $stmt = $this->pdo->prepare('SELECT *
                                     FROM fbo_seens
                                     WHERE user_id = :user_id');
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();

        $numSeen = $stmt->rowCount();

        return $numSeen;
    }

    // Returns the number of films a user as seen as a percentage of the total number of films on the database
    public function getPercentFilmsSeen($user) {
        $countFilms = $this->pdo->prepare('SELECT * FROM fbo_films');
        $countFilms->execute();
        $numFilms = $countFilms->rowCount();

        $id = $user->getID();
        $stmt = $this->pdo->prepare('SELECT *
                                     FROM fbo_seens
                                     WHERE user_id = :user_id');
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();

        $numSeen = $stmt->rowCount();

        $percent = (int)(($numSeen/$numFilms) * (100/1));
        
        return $percent;
    }

    // Gets the last seens of a film
    // If mustHaveTweeview is set it only returns seens that have a tweeview
    public function getFilmsLastSeens ($numToGet, $film, $mustHaveTweeview = false) {
        if (!$mustHaveTweeview) {
            $stmt = $this->pdo->prepare('SELECT user_id, film_id, rating, tweeview, UNIX_TIMESTAMP(date) as date
                                         FROM fbo_seens
                                         WHERE film_id = :film_id
                                         ORDER BY date DESC
                                         LIMIT :num_to_get');
        } else {
            $stmt = $this->pdo->prepare('SELECT user_id, film_id, rating, tweeview, UNIX_TIMESTAMP(date) as date
                                         FROM fbo_seens
                                         WHERE film_id = :film_id && tweeview != ""
                                         ORDER BY date DESC
                                         LIMIT :num_to_get');
        }
        $filmID = $film->getID();
        $stmt->bindParam(':film_id', $filmID);
        $stmt->bindParam(':num_to_get', $numToGet, PDO::PARAM_INT); // casting necessary here due to php bug
        $stmt->execute();
        
        $seens = array();

        while ($row = $stmt->fetch()) {
            $seen = $this->load($row); 
            $seens[] = $seen;
        }

        return $seens;
    }

    // Returns true if a user has seen the film
    public function userHasSeen($user, $film) {
        $userID = $user->getID();
        $filmID = $film->getID();
        $stmt = $this->pdo->prepare('SELECT * FROM fbo_seens WHERE user_id = :user_id && film_id = :film_id');
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':film_id', $filmID);
        $stmt->execute();

        if ($stmt->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    // Returns true if a user has rated the film
    public function userHasRated($user, $film) {
        $userID = $user->getID();
        $filmID = $film->getID();
        $stmt = $this->pdo->prepare('SELECT rating FROM fbo_seens WHERE user_id = :user_id && film_id = :film_id');
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

    // Updates a seen's database record
    public function save($seen) {
        $userID = $seen->getUserID();
        $filmID = $seen->getFilmID();
        $rating = $seen->getRating();
        $tweeview = $seen->getTweeview();
        $stmt = $this->pdo->prepare('UPDATE fbo_seens
                                     SET rating = :rating, tweeview = :tweeview
                                     WHERE user_id = :user_id && film_id = :film_id');
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':film_id', $filmID);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':tweeview', $tweeview);
        $stmt->execute();
    }

    // Get a film's average rating overall
    public function getAverageRating($film) {
        $filmID = $film->getID();
        $get = $this->pdo->prepare('SELECT * FROM fbo_seens
                                           WHERE film_id = :film_id');
        $get->bindParam('film_id', $filmID);
        $get->execute();

        $ratings = array();

        while ($row = $get->fetch()) {
            if ($row['rating']) {
                $ratings[] = $row['rating'];
            }
        }

        if (array_sum($ratings)) {
            $averageRating = array_sum($ratings)/count($ratings);
        } else {
            $averageRating = 0;
        }

        return $averageRating;
    }

    // Get a user's positivity based on all their film ratings
    public function getPositivity($user) {
        $userID = $user->getID();
        $get = $this->pdo->prepare('SELECT rating FROM fbo_seens WHERE user_id = :user_id && rating > 0');
        $get->bindParam(':user_id', $userID);
        $get->execute();

        $ratings = array();

        while ($row = $get->fetch()) {
            $ratings[] = $row['rating'];
        }

        $numRated = count($ratings);

        if (!$numRated) {
            return 0;
        }

        $totalOfRatings = array_sum($ratings);
        
        $averageRating = $totalOfRatings/$numRated;
        
        $percent = (int)(($averageRating/5) * (100/1));
        
        return $percent;
    }

    // Gets two users compatibility as a percentage based on all of their ratings
    public function getCompatibility($user1, $user2) {
        $user1ID = $user1->getID();
        $user2ID = $user2->getID();
        $getSeens = $this->pdo->prepare('SELECT * FROM fbo_seens WHERE user_id = :user_id');

        $getSeens->bindParam(':user_id', $user1ID);
        $getSeens->execute();

        $user1Seens = array();
        while ($row = $getSeens->fetch()) {
            if ($row['rating']) {
                $user1Seens[$row['film_id']] = $row['rating'];
            }
        }

        $getSeens->bindParam(':user_id', $user2ID);
        $getSeens->execute();

        $user2Seens = array();
        while ($row = $getSeens->fetch()) {
            if ($row['rating']) {
                $user2Seens[$row['film_id']] = $row['rating'];
            }
        }
        
        $totalDiff= array();
        foreach ($user1Seens as $key1=>$user1Rating) {
            foreach ($user2Seens as $key2=>$user2Rating) {
                if ($key1 == $key2) {
                    $diff = $user1Rating - $user2Rating;
                    if ($diff < 0) {
                        $diff = $diff * -1;
                    }
                    $diff = 5 - $diff;
                    $totalDiff[] = $diff;
                }
            }
        }

        if (empty($totalDiff) ) {
            return 0;
        }

        $average = array_sum($totalDiff) / count($totalDiff);

        $percent = (int)(($average / 5) * (100/1));

        return $percent;
    }

    // Deletes a seen record from the database
    public function delete($seen) {
        $userID = $seen->getUserID();
        $filmID = $seen->getFilmID();
        $stmt = $this->pdo->prepare('DELETE FROM fbo_seens
                                     WHERE user_id = :user_id && film_id = :film_id');
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':film_id', $filmID);
        $stmt->execute();
    }

    // Deletes all of a user's seens (usually used just before a user is deleted)
    public function deleteAllUsersSeens ($user) {
        $userID = $user->getID();
        $delete = $this->pdo->prepare('DELETE FROM fbo_seens
                                       WHERE user_id = :user_id');
        $delete->bindParam(':user_id', $userID);
        $delete->execute();
    }

    // Deletes all of a film's seens (usually used just before a user is deleted)
    public function deleteAllFilmsSeens($film) {
        $filmID = $film->getID();
        $delete = $this->pdo->prepare('DELETE FROM fbo_seens
                                              WHERE film_id = :film_id');
        $delete->bindParam(':film_id', $filmID);
        $delete->execute();
    }

    // Creates and returns a Seen object based on a row from the database
    protected function load($row) {
        $userID = $row['user_id'];
        $filmID = $row['film_id'];
        $rating = $row['rating'];
        $date = $row['date'];
        $tweeview = $row['tweeview'];

        $seen = new Seen($userID, $filmID, $rating, $date, $tweeview);

        return $seen;
    }
}
