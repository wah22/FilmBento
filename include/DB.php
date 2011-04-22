<?php

class DB {
    private static $instance;
    
    private function __construct() {
    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                                      DB_USERNAME,
                                      DB_PASSWORD);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}
