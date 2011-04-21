<?php

class UserModel {

    function create($email, $handle, $password) {
        $password = md5($password);

        if (! $this->getUser('handle', $handle) && !$this->getUser('email', $email)) {
            // save user info
            $stmt = DB::getInstance()->prepare('INSERT INTO fr_users VALUES ( NULL, :email, :handle, :password, 0000-00-00 )');
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':handle', $handle);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
        } else {
            return false;
        }
    }

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
        $user->setDOB(strtotime($row['dob']));
        $user->setSex($row['sex']);
        $user->setLocation($row['location']);
        $user->setTwitter($row['twitter']);

        return $user;
    }

    function save($user) {
        $email = $user->getEmail();
        $handle = $user->getHandle();
        $password = $user->getPassword();
        $id = $user->getID();
        $location = $user->getLocation();
        $sex = $user->getSex();
        $twitter = $user->getTwitter();

        if ($user->getDOB()) {
            $dob = date('Y-m-d', $user->getDOB());
        } else {
            $dob = false;
        }

        $stmt = DB::getInstance()->prepare('UPDATE fr_users
                                            SET email = :email, handle = :handle, password = :password, dob = :dob, sex = :sex, location = :location, twitter = :twitter
                                            WHERE id = :user_id');
        
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':handle', $handle);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user_id', $id);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':twitter', $twitter);
        $stmt->execute();
    }

    function delete($user) {
        $id = $user->getID();
        $stmt = DB::getInstance()->prepare('DELETE FROM fr_users
                                            WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
