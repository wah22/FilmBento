<header>
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
                <?php if (LoginManager::getInstance()->userLoggedIn()) : ?>
                <li><a href="<?php echo LoginManager::getInstance()->getLoggedInUser()->getPath(); ?>"><?php echo LoginManager::getInstance()->getLoggedInUser()->gethandle(); ?></a></li> |
                <li><a href="/settings">Account Settings</a></li> |
                <li><a href="/?controller=LoginController&function=LogOut">Log Out</a></li>
                <?php else : ?>
                <li><a href="/login">Log In</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>
<?php include ROOT_PATH . '/include/views/navbar.php'; ?>