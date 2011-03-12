<?php

class UserModel {

    function getUser($by, $value) {
        $user = new User();

        if ($by == 'handle') {
            $stmt = DB::getInstance()->prepare('SELECT * FROM fr_users WHERE handle = :value');
        } else if ($by == 'id') {
            $stmt = DB::getInstance()->prepare('SELECT * FROM fr_users WHERE id = :value');
        } else if ($by == 'email') {
             $stmt = DB::getInstance()->prepare('SELECT * FROM fr_users WHERE email = :value');
        } else {
            throw new Exception('Parameters must be id or handle');
        }
        
        $stmt->bindParam(':value', $value);
        $stmt->execute();

        if ( !$stmt->rowCount() ) {
            return false;
        }
        
        $row = $stmt->fetch();

        $user->setID($row['id']);
        $user->setEmail($row['email']);
        $user->setHandle($row['handle']);
        $user->setPassword($row['password']);

        // create the user's seen films

        // initiate a film model to handle creating the films for the list
        $filmModel = new FilmModel();
               
        $stmt = DB::getInstance()->prepare('SELECT * FROM fr_seens WHERE user_id = :user_id');
        $id = $user->getID();
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $filmID = $row['film_id'];
            $rating = $row['rating'];
            $seen = new Seen($id, $filmID, $rating);
            $user->addToSeens($seen);
        }

        // initiate lists
        $stmt2 = DB::getInstance()->prepare('SELECT * FROM fr_lists');
        $stmt2->execute();
        while ($row2 = $stmt2->fetch()) {
            $name = $row2['name'];
            $listID = $row2['id'];

            $stmt = DB::getInstance()->prepare('SELECT * FROM fr_list_entries WHERE user_id = :user_id && list_id = :list_id ORDER BY rank ASC');
            $id = $user->getID();
            $stmt->bindParam(':user_id', $id);
            $stmt->bindParam(':list_id', $listID);
            $stmt->execute();
            $list = new FilmList($listID, $name);
            while ($row = $stmt->fetch()) {
                if ($filmModel->getFilm('id', $row['film_id'])) {
                    $seen = new Seen($id, $row['film_id']);
                    $list->addSeen($seen);
                }
            }
            $user->addList($list);
        }
        return $user;
    }

    function create($email, $handle, $password) {
        $password = md5($password);

        if (! $this->getUser('handle', $handle) && !$this->getUser('email', $email)) {
            // save user info
            $stmt = DB::getInstance()->prepare('INSERT INTO fr_users VALUES ( NULL, :email, :handle, :password )');
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':handle', $handle);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
        } else {
            return false;
        }
    }

    function save($user) {

        /*
        $email = $user->getEmail(); $stmt->bindParam(':email', $email);
        $handle = $user->getHandle(); $stmt->bindParam(':handle', $handle);
        $password = $user->getPassword(); $stmt->bindParam(':password', $password);
        $stmt->execute();
        */
        
        // save seens
        $stmt = DB::getInstance()->prepare('SELECT * FROM fr_seens WHERE user_id = :user_id && film_id = :film_id');
        $userID = $user->getID(); $stmt->bindParam(':user_id', $userID);

        $updateStmt = DB::getInstance()->prepare('UPDATE fr_seens SET rating = :rating WHERE user_id = :user_id && film_id = :film_id');

        foreach ($user->getSeens() as $seen) {
            $filmID = $seen->getFilm()->getID();
            $rating = $seen->getRating();
            $stmt->bindParam(':film_id', $filmID);
            $stmt->execute();

            if (!$stmt->rowCount()) {
                $stmt2 = DB::getInstance()->prepare('INSERT INTO fr_seens VALUES ( NULL, :user_id, :film_id, 0)');
                $stmt2->bindParam(':user_id', $userID);
                $stmt2->bindParam(':film_id', $filmID);
                $stmt2->execute();
            } else {
                $updateStmt->bindParam(':user_id', $userID);
                $updateStmt->bindParam(':film_id', $filmID);
                $updateStmt->bindParam(':rating', $rating);
                $updateStmt->execute();
            }
        }

        // save lists
        foreach ($user->getLists() as $list) {
           
            $checkStmt = DB::getInstance()->prepare('SELECT * FROM fr_list_entries WHERE rank = :rank && list_id = :list_id && user_id = :user_id');
            $insertStmt = DB::getInstance()->prepare('INSERT INTO fr_list_entries VALUES ( NULL, :user_id, :film_id, :rank, :list_id )');
            $stmt = DB::getInstance()->prepare('UPDATE fr_list_entries SET film_id = :film_id WHERE user_id = :user_id && list_id = :list_id && rank = :rank');
            $userID = $user->getID();
            $stmt->bindParam(':user_id', $userID);
            $checkStmt->bindParam(':user_id', $userID);

            $listID = $list->getID();
            $stmt->bindParam(':list_id', $listID);
            $checkStmt->bindParam(':list_id', $listID);

            $insertStmt->bindParam(':user_id', $userID);
            $insertStmt->bindParam(':list_id', $listID);

            foreach ($list->getSeens() as $rank=>$seen) {
                $rank++;
                $filmID = $seen->getFilm()->getID();
                $stmt->bindParam(':film_id', $filmID); 
                $stmt->bindParam(':rank', $rank);
                $checkStmt->bindParam(':rank', $rank);
                $checkStmt->execute();
                if ($checkStmt->rowCount()) {
                    $stmt->execute();
                } else {
                    $insertStmt->bindParam(':rank', $rank);
                    $insertStmt->bindparam(':film_id', $filmID);
                    $insertStmt->execute();
                }
            }

            // delete the extra entries
            $delstmt = DB::getInstance()->prepare('DELETE FROM fr_list_entries WHERE user_id = :user_id && list_id = :list_id && rank > :count');
            $count = count($list->getSeens());
            $delstmt->bindParam(':count', $count);
            $delstmt->bindParam(':list_id', $listID);
            $delstmt->bindParam(':user_id', $userID);
            $delstmt->execute();
        }
    }
}