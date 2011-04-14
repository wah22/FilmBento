<?php

class SiteDescriptionController extends Controller {
    
    function index() {
        $this->view->load('site_description_view');
    }
}