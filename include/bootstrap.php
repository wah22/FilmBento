<?php

require_once('../config.php');

define('ROOT_PATH', $root_path);

function __autoload($class_name) {
    require_once(ROOT_PATH . '/include/' . $class_name . '.php');
}

if ($testing == true) {
    ini_set('display_errors',1);
    error_reporting(E_ALL|E_STRICT);
}