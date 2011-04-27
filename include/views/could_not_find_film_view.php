<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmBento / Could Not Find Film</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <div id="pageWrapper">

    <?php require_once 'header.php'; ?>

    <div id="couldntFind">

        <p id="uh-oh">Huh?</p>

        <img src="<?php echo BASE_URL; ?>/images/tosh-confused.jpg">

        <div id="text">
            <p>We couldn't find the film you entered on our database.</p>
            <p><a href="<?php echo BASE_URL; ?>/add">Add a film?</a></p>
        </div>

    </div>

    <?php include "footer.php"; ?>

    </div>
</body>
</html>
