<?php

require_once('../config.php');

define('ROOT_PATH', $root_path);

define('DB_HOST', $db_host);
define('DB_NAME', $db_name);
define('DB_PORT', $db_port);
define('DB_USERNAME', $db_username);
define('DB_PASSWORD', $db_password);

function __autoload($class_name) {
    require_once(ROOT_PATH . '/include/' . $class_name . '.php');
}

if ($testing == true) {
    ini_set('display_errors',1);
    error_reporting(E_ALL|E_STRICT);
}