<?php

class CreateListController extends PrivateController {

    function index() {

        $this->view->load('create_list_view');
    }

    function submit() {
        if(empty($_POST['name'])) {
            $this->index();
            return;
        }

        $list = $this->listModel->create($_POST['name'], $_POST['maxEntries']);
        $this->listModel->activateList($this->user, $list);
        $this->index();
    }
}