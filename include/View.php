<?php

class View {

    function load ($filename, $data) {
        require_once(ROOT_PATH . '/include/views/' . $filename . '.php');
    }
}