<?php

class Rating {
    
    private $value;

    function __construct ($value) {
        $this->value = $value;
    }

    function getValue() {
        return $this->value;
    }
}