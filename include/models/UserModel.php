<?php

class UserModel extends Model {

    function __construct() {
        parent::__construct();
    }

    // Add a user to the database.
    public function create($email, $handle, $password) {
        // encrypt the password
        $password = md5($password);

        // If the user doesn't already exist in the database insert it.
        if (! $this->getUser('handle', $handle) && !$this->getUser('email', $email)) {
            $stmt = $this->pdo->prepare('INSERT INTO fr_users VALUES ( NULL, :email, :handle, :password, 0000-00-00, "", 00, "", "user")');
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':handle', $handle);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
        } else {
            return false;
        }
    }

    // Gets a user from the database and returns it.
    // The $by variable is the criteria you want to use to select the user eg, email
    function getUser($by, $value) {
        // Set the query based on the get criteria
        if ($by == 'handle') {
            $stmt = $this->pdo->prepare('SELECT * FROM fr_users WHERE handle = :value');
        } else if ($by == 'id') {
            $stmt = $this->pdo->prepare('SELECT * FROM fr_users WHERE id = :value');
        } else if ($by == 'email') {
             $stmt = $this->pdo->prepare('SELECT * FROM fr_users WHERE email = :value');
        } else {
            throw new Exception('Parameters must be id or handle');
        }
        
        $stmt->bindParam(':value', $value);
        $stmt->execute();

        // If the user doesn't exist return false
        if ( !$stmt->rowCount() ) {
            return false;
        }
        
        $row = $stmt->fetch();

        $user = $this->load($row);

        return $user;
    }

    // Creates user objects for all users in the database and returns them as an array.
    function getAllUsers() {
        $get = $this->pdo->prepare('SELECT * FROM fr_users');
        $get->execute();
        
        // Load a user object for each database entry
        $users = array();
        while ($row = $get->fetch()) {
            $users[] = $this->load($row);
        }

        return $users;
    }

    // Updates a user in the database.
    function save($user) {
        $email = $user->getEmail();
        $handle = $user->getHandle();
        $password = $user->getPassword();
        $id = $user->getID();
        $location = $user->getLocation();
        $sex = $user->getSex();
        $twitter = $user->getTwitter();
        $dob = date('Y-m-d', $user->getDOB());

        $stmt = $this->pdo->prepare('UPDATE fr_users
                                     SET email = :email,
                                        handle = :handle,
                                        password = :password,
                                        dob = :dob,
                                        sex = :sex,
                                        location = :location,
                                        twitter = :twitter
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

    // Deletes a user from the database.
    public function delete($user) {
        $id = $user->getID();
        $stmt = $this->pdo->prepare('DELETE FROM fr_users
                                     WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    
    // Instantiates and returns  a user object using a row from the database.
    private function load($row) {
        if ($row['rank'] == 'admin') {
            $user = new Admin();
        } else {
            $user = new User();
        }

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
}
