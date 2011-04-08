<?php

class AddListController extends PrivateController {

    function index() {
        $allLists = array();
        foreach ($this->listModel->getAllLists() as $list) {
            if (!$this->listModel->listActive($this->user, $list)) {
                $allLists[] = $list;
            }
        }
        $data['lists'] = $allLists;

        $this->view->load('add_list_view', $data);
    }
}