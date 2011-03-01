<?php

class DB {
    private static $instance;
    
    private function __contruct() {
    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new PDO('mysql:
                                      host=localhost;
                                      dbname=fr;
                                      port=4492',
                                      'root',
                                      'NiShi0Ji');
        }
        return self::$instance;
    }
}