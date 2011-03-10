    <div id="header">
        <a href="/">
            <hgroup>
<<<<<<< HEAD
                <h1>FilmBento</h1>
=======
                <h1>Site Name</h1>
>>>>>>> 043932e38ebf62fd41badfc0e105c345de69f6a4
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