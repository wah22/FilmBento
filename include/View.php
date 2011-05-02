<?php

/**
* View
* Handles loading html pages.
*/

class View {

    // Takes a filename/path to the view file and loads it.
    // Optionally a data array can be passed to it if the view requires data from the calling controller.
    function load ($filename, $data = array()) {
        include ROOT_PATH . '/include/views/' . $filename . '.php';
    }
}
