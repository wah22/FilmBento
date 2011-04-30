<?php 

class AdminController extends PrivateController {

    function __construct() {
        parent::__construct();

        if (get_class($this->user) != 'Admin') {
            $this->redirectToLogin();
        }
    }

    function index() {
        $this->view->load('admin_view');
    }

    function users() {
        $users = $this->userModel->getAllUsers();
        $data = array(
            'users' => $users
            );

        $this->view->load('admin_users_view', $data);
    }

    function films() {
        $films = $this->filmModel->getAllFilms();
        $data = array(
            'films' => $films
            );
        $this->view->load('admin_films_view', $data);
    }

    public function site_settings() {
        if (isset($_POST['submit'])) {
            SettingsManager::getInstance()->setSetting('disallowed_handles', $_POST['disallowed_handles']);
        }

        $data = array(
            'site_settings' => array(
                            'disallowed_handles' => SettingsManager::getInstance()->getSetting('disallowed_handles')
                            )
                );
        $this->view->load('admin_site_settings_view', $data);
    }

    function deleteUser() {
        if (!isset($_GET['user'])) {
            return;
        } else {
            $userID = $_GET['user'];
        }

        $user = $this->userModel->getUser('id', $userID);
        
        $this->listModel->deleteUsersLists($user);       
        $this->seenModel->deleteAllUsersSeens($user);
        $this->userModel->delete($user);

        $location = BASE_URL . "/admin/users";
        header("Location: $location");
    }

    function deleteFilm() {
        if (!isset($_GET['film'])) {
            return;
        } else {
            $filmID = $_GET['film'];
        }

        $film = $this->filmModel->getFilm('id', $filmID);

        $this->listModel->deleteFilmFromLists($film);
        $this->seenModel->deleteAllFilmsSeens($film);
        $this->filmModel->delete($film);

        $location = BASE_URL . "/admin/films";
        header("Location: $location");
    }
}
