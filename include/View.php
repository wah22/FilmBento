<?php

class View {

    function load ($filename, $data) {
        include ROOT_PATH . '/include/views/' . $filename . '.php';
    }
}