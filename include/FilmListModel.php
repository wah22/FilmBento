<?php

class FilmListModel {

    function __construct() {
        
    }

    function getList($user, $listID) {
        $userID = $user->getID();
        $stmt = DB::getInstance()->prepare('SELECT * FROM fbo_lists WHERE id = :list_id');
        $stmt->bindParam('list_id', $listID);
        $stmt->execute();

        $entryStmt = DB::getInstance()->prepare('SELECT * FROM fbo_list_entries
                                    WHERE user_id = :user_id && list_id = :list_id ORDER BY rank ASC');
        $entryStmt->bindParam(':user_id', $userID);
        $entryStmt->bindParam('list_id', $listID);
        $entryStmt->execute();

        $row = $stmt->fetch();

        $list = new FilmList($userID, $row['id'], $row['name']);
        $list->setMaxEntries($row['max_entries']);

        while ($row = $entryStmt->fetch()) {
            $list->addEntry($row['film_id']);
        }
        return $list;
    }

    function getListByName($name) {
        $get = DB::getInstance()->prepare('SELECT * FROM fbo_lists WHERE name = :name');
        $get->bindParam(':name', $name);
        $get->execute();

        $row = $get->fetch();
        $list = new FilmList();
        $list->setID($row['id']);
        $list->setName($row['name']);
        return $list;
    }

    function listActive($user, $list) {
        $userID = $user->getID();
        $listID = $list->getID();
        $stmt = DB::getInstance()->prepare('SELECT * FROM fbo_user_active_lists
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

    function getAllLists() {
        $stmt = DB::getInstance()->prepare('SELECT *
                      FROM fbo_lists');
        $stmt->execute();
        $lists = array();
        while ($row = $stmt->fetch()) {
            $list = new FilmList(0, $row['id'], $row['name']);
            $lists[] = $list;
        }
        return $lists;
    }

    function getLists($user) {
        $userID = $user->getID();

        $stmt = DB::getInstance()->prepare('SELECT fbo_lists.id as id, fbo_lists.name as name, fbo_lists.max_entries as max_entries
                                          FROM fbo_lists, fbo_user_active_lists
                                          WHERE fbo_lists.id = fbo_user_active_lists.list_id
                                                && fbo_user_active_lists.user_id = :user_id
                                          ORDER BY fbo_lists.name');
        $stmt->bindParam(':user_id', $userID);
        $stmt->execute();

        $entryStmt = DB::getInstance()->prepare('SELECT * FROM fbo_list_entries
                                    WHERE user_id = :user_id && list_id = :list_id ORDER BY rank ASC');
        $entryStmt->bindParam(':user_id', $userID);

        $lists = array();
        while ($row = $stmt->fetch()) {
            $list = new FilmList($userID, $row['id'], $row['name']);
            $list->setMaxEntries($row['max_entries']);

            $entryStmt->bindParam('list_id', $row['id']);

            $entryStmt->execute();

            while ($row = $entryStmt->fetch()) {
                $list->addEntry($row['film_id']);
            }
            $lists[] = $list;
        }

        return $lists;
    }

    function save($list) {
        $userID = $list->getUserID();
        $listID = $list->getID();

        $stmt = DB::getInstance()->prepare('UPDATE fbo_list_entries
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
                $insertStmt = DB::getInstance()->prepare('INSERT INTO fbo_list_entries VALUES (NULL, :user_id, :film_id, :rank, :list_id)');
                $insertStmt->bindParam(':user_id', $userID);
                $insertStmt->bindParam(':list_id', $listID);
                $insertStmt->bindParam(':rank', $rank);
                $insertStmt->bindParam('film_id', $entry);
                $insertStmt->execute();
            }
        }

        $stmt = DB::getInstance()->prepare('DELETE FROM fbo_list_entries
                                          WHERE rank > :maxRank && user_id = :user_id && list_id = :list_id');
        $maxRank = count($list->getEntries());
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam('list_id', $listID);
        $stmt->bindParam(':maxRank', $maxRank);
        $stmt->execute();
    }

    function activateList($user, $list) {
        $userID = $user->getID();
        $listID = $list->getID();

        $check = DB::getInstance()->prepare('SELECT * FROM fbo_user_active_lists
                                             WHERE user_id = :user_id && list_id = :list_id');
        $check->bindParam(':user_id', $userID);
        $check->bindParam('list_id', $listID);
        $check->execute();
        
        if ($check->rowCount()) {
            return false;
        }

        $insert = DB::getInstance()->prepare('INSERT INTO fbo_user_active_lists
                                            VALUES ( NULL, :user_id, :list_id )');
        $insert->bindParam('user_id', $userID);
        $insert->bindParam('list_id', $listID);
        $insert->execute();
    }

    function deactivateList($user, $list) {
        $userID = $user->getID();
        $listID = $list->getID();

        $delete = DB::getInstance()->prepare('DELETE FROM fbo_user_active_lists
                                            WHERE user_id = :user_id && list_id = :list_id');
        $delete->bindParam(':user_id', $userID);
        $delete->bindParam(':list_id', $listID);
        $delete->execute();

        $deleteEntries = DB::getInstance()->prepare('DELETE FROM fbo_list_entries
                                                     WHERE user_id = :user_id && list_id = :list_id');
        $deleteEntries->bindParam(':user_id', $userID);
        $deleteEntries->bindParam(':list_id', $listID);
        $deleteEntries->execute();
    }

    function create($name, $maxEntries) {
        $insert = DB::getInstance()->prepare('INSERT into fbo_lists
                                              VALUES( NULL, :name, :max_entries)');
        $insert->bindParam(':name', $name);
        $insert->bindParam(':max_entries', $maxEntries);
        $insert->execute();

        $list = $this->getListByName($name);
        return $list;
    }
}