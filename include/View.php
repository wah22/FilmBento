<?php

class View {

    function load ($filename, $data = array()) {
        include ROOT_PATH . '/include/views/' . $filename . '.php';
    }
}