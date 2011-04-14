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

        <img src="images/tosh-confused.jpg">

        <div id="text">
            <p>We couldn't find the film you entered on our database.</p>
            <p>Please check that you spelled the name correctly.</p>
            <p>You can add the film to our database <a href="/?controller=AddFilmController">here</a>.</p>
        </div>

    </div>

    <?php include "footer.php"; ?>

    </div>
</body>
</html>
