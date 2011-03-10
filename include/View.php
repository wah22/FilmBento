<?php

class View {

    function load ($filename, $data = array()) {
        require_once(ROOT_PATH . '/include/views/' . $filename . '.php');
    }
}