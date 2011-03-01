<?php

class UserModel {

    function getUser($handle) {
        $user = new User();

        $stmt = DB::getInstance()->prepare('SELECT * FROM fr_users WHERE handle = :handle');
        $stmt->bindParam(':handle', $handle);
        $stmt->execute();
        $row = $stmt->fetch();

        $user->setID($row['id']);
        $user->setEmail($row['email']);
        $user->setHandle($row['handle']);

        // create the user's seen films

        // initiate a film model to handle creating the films for the list
        $filmModel = new FilmModel();

        $stmt = DB::getInstance()->prepare('SELECT * FROM fr_seens WHERE user_id = :user_id');
        $id = $user->getID();
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $film = $filmModel->getFilm($row['film_id']);
            $user->addToSeenFilms($film);
        }
        return $user;
    }
}