<?php

/**
* FilmListModel
* Handles generating FilmList objects from database records
* And the updating and deletion of list records
*/
class FilmListModel extends Model {

    function __construct() {
        parent::__construct();
    }

    // Creates and returns a list object
    public function create($name, $maxEntries, $description, $createdByID) {
        $insert = $this->pdo->prepare('INSERT into fbo_lists
                                              VALUES( NULL, :name, :max_entries, :description, :created_by)');
        $insert->bindParam(':name', $name);
        $insert->bindParam(':max_entries', $maxEntries);
        $insert->bindParam(':description', $description);
        $insert->bindParam(':created_by', $createdByID);
        $insert->execute();

        $list = $this->getListByName($name);

        return $list;
    }

    // This returns a list that is not tied to any specific user and has no entries
    // Used to just get info such as title and description
    public function getListByName($name) {
        $get = $this->pdo->prepare('SELECT * FROM fbo_lists
                                    WHERE name = :name');
        $get->bindParam(':name', $name);
        $get->execute();

        $row = $get->fetch();
        
        $list = $this->load($row);

        return $list;
    }

    // Gets all lists (without entries)
    public function getAllLists() {
        $stmt = $this->pdo->prepare('SELECT *
                      FROM fbo_lists');
        $stmt->execute();

        $lists = array();

        while ($row = $stmt->fetch()) {
            $list = $this->load($row);
            $lists[] = $list;
        }

        return $lists;
    }


    // Gets a users list(with its entries) based on its id
    public function getList($user, $listID) {
        $userID = $user->getID();
        $stmt = $this->pdo->prepare('SELECT * FROM fbo_lists
                                     WHERE id = :list_id');
        $stmt->bindParam('list_id', $listID);
        $stmt->execute();

        $entryStmt = $this->pdo->prepare('SELECT * FROM fbo_list_entries
                                          WHERE user_id = :user_id && list_id = :list_id
                                          ORDER BY rank ASC');
        $entryStmt->bindParam(':user_id', $userID);
        $entryStmt->bindParam('list_id', $listID);
        $entryStmt->execute();

        $row = $stmt->fetch();

        $list = $this->load($row);

        while ($row = $entryStmt->fetch()) {
            $list->addEntry($row['film_id']);
        }

        return $list;
    }

    // Gets ALL a user's lists, with entries
    public function getLists($user) {
        $userID = $user->getID();

        // Selects only the lists active on the user
        $stmt = $this->pdo->prepare('SELECT fbo_lists.id as id, fbo_lists.name as name, fbo_lists.max_entries as max_entries, fbo_lists.created_by as created_by, fbo_lists.description as description
                                     FROM fbo_lists, fbo_user_active_lists
                                     WHERE fbo_lists.id = fbo_user_active_lists.list_id
                                                && fbo_user_active_lists.user_id = :user_id
                                     ORDER BY fbo_lists.name');
        $stmt->bindParam(':user_id', $userID);
        $stmt->execute();

        $entryStmt = $this->pdo->prepare('SELECT * FROM fbo_list_entries
                                          WHERE user_id = :user_id && list_id = :list_id ORDER BY rank ASC');
        $entryStmt->bindParam(':user_id', $userID);

        $lists = array();

        while ($row = $stmt->fetch()) {
            $list = $this->load($row);            

            $entryStmt->bindParam('list_id', $row['id']);
            $entryStmt->execute();

            while ($row = $entryStmt->fetch()) {
                $list->addEntry($row['film_id']);
            }
            $lists[] = $list;
        }

        return $lists;
    }

    // Checks if a list is active on a user
    public function listActive($user, $list) {
        $userID = $user->getID();
        $listID = $list->getID();
        $stmt = $this->pdo->prepare('SELECT * FROM fbo_user_active_lists
                                     WHERE user_id = :user_id && list_id = :list_id');
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam('list_id', $listID);
        $stmt->execute();

        if($stmt->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    // Updates a lists record on the database
    public function save($list) {
        $userID = $list->getUserID();
        $listID = $list->getID();
        $stmt = $this->pdo->prepare('UPDATE fbo_list_entries
                                            SET film_id = :film_id
                                            WHERE list_id = :list_id && user_id = :user_id && rank = :rank');

        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam(':list_id', $listID);

        foreach ( $list->getEntries() as $i=>$entry ) {
            $rank = $i+1;
            $stmt->bindParam(':rank', $rank);
            $stmt->bindParam(':film_id', $entry);
            $stmt->execute();
            if (!$stmt->rowCount()) {
                $insertStmt = $this->pdo->prepare('INSERT INTO fbo_list_entries VALUES (NULL, :user_id, :film_id, :rank, :list_id)');
                $insertStmt->bindParam(':user_id', $userID);
                $insertStmt->bindParam(':list_id', $listID);
                $insertStmt->bindParam(':rank', $rank);
                $insertStmt->bindParam('film_id', $entry);
                $insertStmt->execute();
            }
        }

        $stmt = $this->pdo->prepare('DELETE FROM fbo_list_entries
                                     WHERE rank > :maxRank && user_id = :user_id && list_id = :list_id');
        $maxRank = count($list->getEntries());
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam('list_id', $listID);
        $stmt->bindParam(':maxRank', $maxRank);
        $stmt->execute();
    }

    // Activates a list on a user
    public function activateList($user, $list) {
        $userID = $user->getID();
        $listID = $list->getID();
        $check = $this->pdo->prepare('SELECT * FROM fbo_user_active_lists
                                      WHERE user_id = :user_id && list_id = :list_id');
        $check->bindParam(':user_id', $userID);
        $check->bindParam('list_id', $listID);
        $check->execute();
        
        // If the list is already active return
        if ($check->rowCount()) {
            return false;
        }

        $insert = $this->pdo->prepare('INSERT INTO fbo_user_active_lists
                                       VALUES ( NULL, :user_id, :list_id )');
        $insert->bindParam('user_id', $userID);
        $insert->bindParam('list_id', $listID);
        $insert->execute();
    }

    // Deactivates a list on a user
    public function deactivateList($user, $list) {
        $userID = $user->getID();
        $listID = $list->getID();
        $delete = $this->pdo->prepare('DELETE FROM fbo_user_active_lists
                                       WHERE user_id = :user_id && list_id = :list_id');
        $delete->bindParam(':user_id', $userID);
        $delete->bindParam(':list_id', $listID);
        $delete->execute();

        // Then delete all the users entries on that list
        $deleteEntries = $this->pdo->prepare('DELETE FROM fbo_list_entries
                                              WHERE user_id = :user_id && list_id = :list_id');
        $deleteEntries->bindParam(':user_id', $userID);
        $deleteEntries->bindParam(':list_id', $listID);
        $deleteEntries->execute();
    }

    // This removes a film from all lists
    // used before the film itself is deleted
    public function deleteFilmFromLists($film) {
        $filmID = $film->getID();
        $getLists = $this->pdo->prepare('SELECT * FROM fbo_lists');
        $getLists->execute();
        $getUsers = $this->pdo->prepare('SELECT * FROM fr_users');

        $userModel = new UserModel();

        while ($row = $getLists->fetch()) {
            $getUsers->execute();
            while ($userRow = $getUsers->fetch()) {
                $user = $userModel->getUser('id', $userRow['id']);
                $list = $this->getList($user, $row['id']);
                $list->remove($filmID);
                $this->save($list);
            }
        }
    }

    // Delete all of a users entries on all lists
    // Used before a user is deleted
    public function deleteUsersLists($user) {
        $userID = $user->getID();
        $delete = $this->pdo->prepare('DELETE FROM fbo_list_entries
                                       WHERE user_id = :user_id');
        $delete->bindParam('user_id', $userID);
        $delete->execute();
    }

    // Builds and returns a list object based on a database row
    private function load($row) {
        $list = new FilmList();

        $list->setID($row['id']);
        $list->setUserID(0);
        $list->setName($row['name']);
        $list->setMaxEntries($row['max_entries']);
        $list->setCreatedByID($row['created_by']);
        $list->setDescription($row['description']);

        return $list;
    }
}
