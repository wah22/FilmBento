<?php

ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

require_once('../config.php');

function __autoload($class_name) {
    require_once(ROOT_PATH . '/include/' . $class_name . '.php');
}
