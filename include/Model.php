<?php

/**
* Model
* The base Model class
*/
abstract class Model {

    // Each model has a reference to a PDO object
    protected $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                                  DB_USERNAME,
                                  DB_PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
}
