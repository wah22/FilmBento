<?php

class DB {
    private static $instance;
    
    private function __contruct() {
    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new PDO('mysql:
                                      host=' . DB_HOST . ';
                                      dbname=' . DB_NAME . ';
                                      port='. DB_PORT,
                                      DB_USERNAME,
                                      DB_PASSWORD);
        }
        return self::$instance;
    }
}