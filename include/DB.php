<?php

class DB {
    private static $instance;
    
    private function __contruct() {
    }

    public static function getInstance() {
            if (empty(self::$instance)) {
                try{
                    self::$instance = new PDO('mysql:
                                              host=localhost;
                                              dbname=fr;
                                              port=4492',
                                              'root',
                                              'NiShi0Ji');
                } catch (Exception $e) {
                    echo "Database not configured correctly:", $e->getMessage();
                    $dbh->rollBack();
                }
            }
            return self::$instance;
    }
}