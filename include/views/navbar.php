<?php if (LoginManager::getInstance()->userLoggedIn()) : ?>

<nav id="navbar">
     <ul>
        <li><a href="/">Home</a></li>
        <li><a href="<?php echo LoginManager::getInstance()->getLoggedInUser()->getPath(); ?>">My Profile</a></li>
        <li><a href="/?controller=ListController">My Lists</a></li>
     </ul>
</nav>

<?php endif; ?>