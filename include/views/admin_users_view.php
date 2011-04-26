<!DOCTYPE html>
 <html lang="en">
 <head>
    <title>FilmBento / Admin</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include ("header.php"); ?> 
            <div id=admin>
                <h1>Admin / Manage Users</h1>
                
                <?php foreach ($data['users'] as $user) : ?>
                <p>
                    <a href="<?php echo $user->getPath(); ?>"><?php echo $user->getHandle(); ?></a> | 
                    <a href="<?php echo BASE_URL; ?>/?controller=AdminController&function=deleteUser&user=<?php echo $user->getID(); ?>">delete</a>
                </p>
                <?php endforeach; ?>
            </div>
        <?php include "footer.php"; ?>
    </div>
</body>
</html>
