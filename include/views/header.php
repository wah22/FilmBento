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
                <li><a href="/login">Log In</a></li>
                <?php else : ?>
                <li><a href="<?php echo LoginManager::getInstance()->getLoggedInUser()->getPath(); ?>"><img src="/images/icons/user.png"><?php echo LoginManager::getInstance()->getLoggedInUser()->gethandle(); ?></a></li> |
                <li><a href="/settings"><img src="/images/icons/user_edit.png">Account Settings</a></li> |
                <li><a href="index.php?controller=LoginController&function=LogOut"><img src="/images/icons/x.png">Log Out</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

<?php require_once 'navbar.php'; ?>