<?php

class FAQController extends Controller {

    function index() {
        $this->view->load('faq_view');
    }
}