<?php

/*
 * Controllers that inheritfrom this class are "private":
 * when a user tries to access them when not logged in they will be
 * re-directed to the log-in page
 *
 * $user is the currently logged in user
 */

abstract class PrivateController extends Controller {

    protected $user;

    function __construct () {
        if (!LoginManager::getInstance()->userLoggedIn()) {
            header ("Location: /login");
        } else {
            $this->user = LoginManager::getInstance()->getLoggedInUser();
        }

        parent::__construct();
    }
}