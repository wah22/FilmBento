    <div id="header">
        <a href="/">
            <hgroup>
                <h1>FilmBento</h1>
                <h2>Track what you watch</h2>
            </hgroup>
        </a>

        <div id="user_panel">
            <?php if (! LoginManager::getInstance()->userLoggedIn()) : ?>
            <a href="/?controller=LoginController">log in</a>
            <?php else : ?>
            Hello, <a href="<?php echo LoginManager::getInstance()->getLoggedInUser()->getPath(); ?>"><?php echo LoginManager::getInstance()->getLoggedInUser()->gethandle(); ?></a>!
            <a href="/?controller=LoginController&function=LogOut">Log out</a>
            <?php endif; ?>
        </div>
    </div>

<?php require_once 'navbar.php'; ?>