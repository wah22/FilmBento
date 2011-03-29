    <div id="header">
        <a href="/">
            <hgroup>
                <h1>FilmBento</h1>
                <h2>Track what you watch.</h2>
                <h3>beta</h3>
            </hgroup>
        </a>

        <div id="user_panel">
            <ul>
                <?php if (! LoginManager::getInstance()->userLoggedIn()) : ?>
                <li><a href="/?controller=LoginController">Log In</a></li>
                <?php else : ?>
                <li><a href="<?php echo LoginManager::getInstance()->getLoggedInUser()->getPath(); ?>"><?php echo LoginManager::getInstance()->getLoggedInUser()->gethandle(); ?></a></li> |
                <li><a href="/?controller=AccountSettingsController">Account Settings</a></li> |
                <li><a href="?controller=LoginController&function=LogOut">Log Out</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

<?php require_once 'navbar.php'; ?>