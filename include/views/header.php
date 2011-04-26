<header>
    <div id="header">
            <hgroup>
                <a href="<?php echo BASE_URL; ?>">
                    <h1>FilmBento</h1>
                    <h2>Track what you watch.</h2>
                    <h3>beta</h3>
                </a>
            </hgroup>
        <?php include ROOT_PATH . '/include/views/navbar.php'; ?>
    </div>
    <div id="user_panel">
            <?php if (LoginManager::getInstance()->userLoggedIn()) : ?>
            <a href="<?php echo LoginManager::getInstance()->getLoggedInUser()->getPath(); ?>" class="left pill primary button"><?php echo LoginManager::getInstance()->getLoggedInUser()->gethandle(); ?></a><a href="/settings" class="middle pill button">Account Settings</a><?php if (get_class(LoginManager::getInstance()->getLoggedInUser()) == 'Admin') : ?><a href="<?php echo BASE_URL; ?>/admin" class="middle pill button">Admin</a><?php endif; ?><a href="/?controller=LoginController&function=LogOut" class="right negative pill button">Log Out</a>
            <?php else : ?>
            <a href="<?php echo BASE_URL; ?>/login"  class="pill button">Log In</a>
            <?php endif; ?>
    </div>
</header>
