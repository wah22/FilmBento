<?php

class FilmListModel {

    function __construct() {
        
    }

    function getList($user, $listID) {
        $userID = $user->getID();
        $stmt = DB::getInstance()->prepare('SELECT * FROM fr_lists WHERE id = :list_id');
        $stmt->bindParam('list_id', $listID);
        $stmt->execute();

        $entryStmt = DB::getInstance()->prepare('SELECT * FROM fr_list_entries
                                    WHERE user_id = :user_id && list_id = :list_id ORDER BY rank ASC');
        $entryStmt->bindParam(':user_id', $userID);
        $entryStmt->bindParam('list_id', $listID);
        $entryStmt->execute();

        $row = $stmt->fetch();

        $list = new FilmList($userID, $row['id'], $row['name']);

        while ($row = $entryStmt->fetch()) {
            $list->addEntry($row['film_id']);
        }
        return $list;
    }

    function getLists($user) {
        $userID = $user->getID();
        $stmt = DB::getInstance()->prepare('SELECT * FROM fr_lists');
        $stmt->bindParam(':user_id', $userID);
        $stmt->execute();

        $entryStmt = DB::getInstance()->prepare('SELECT * FROM fr_list_entries
                                    WHERE user_id = :user_id && list_id = :list_id ORDER BY rank ASC');
        $entryStmt->bindParam(':user_id', $userID);

        $lists = array();
        while ($row = $stmt->fetch()) {
            $list = new FilmList($userID, $row['id'], $row['name']);

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

        $stmt = DB::getInstance()->prepare('UPDATE fr_list_entries
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
                $insertStmt = DB::getInstance()->prepare('INSERT INTO fr_list_entries VALUES (NULL, :user_id, :film_id, :rank, :list_id)');
                $insertStmt->bindParam(':user_id', $userID);
                $insertStmt->bindParam(':list_id', $listID);
                $insertStmt->bindParam(':rank', $rank);
                $insertStmt->bindParam('film_id', $entry);
                $insertStmt->execute();
            }
        }

        $stmt = DB::getInstance()->prepare('DELETE FROM fr_list_entries
                                          WHERE rank > :maxRank && user_id = :user_id && list_id = :list_id');
        $maxRank = count($list->getEntries());
        $stmt->bindParam(':user_id', $userID);
        $stmt->bindParam('list_id', $listID);
        $stmt->bindParam(':maxRank', $maxRank);
        $stmt->execute();
    }
}