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
                <h1>Admin / Manage Films</h1>
                
                <?php foreach ($data['films'] as $film) : ?>
                <p>
                    <a href="<?php echo $film->getPath(); ?>"><?php echo $film->getTitle(); ?></a> | 
                    <a href="<?php echo BASE_URL; ?>/?controller=AdminController&function=deleteFilm&film=<?php echo $film->getID(); ?>">delete</a>
                </p>
                <?php endforeach; ?>
            </div>
        <?php include "footer.php"; ?>
    </div>
</body>
</html>
