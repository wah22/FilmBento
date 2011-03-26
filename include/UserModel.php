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
        
    }
}