<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <?php include("header.php"); ?>
    <div id=premise style="position: relative; top:10px;">
        <p>FilmBento is a simple tool that tracks the films you watch.</p>
        <p>Every time you see a film, you log it to your page here.</p>
        <p>Then you share your page with your buddies, or whatever.</p>
    </div>
    <div id ="front-image">
        <img src ="/images/tosh.jpg" alt = "Tosh">
        <span style ="font-size:80px; font-weight: bold;">Seen it?</span><br>
        <a href ="/?controller=JoinController" style ="position:absolute; right:23px; bottom:0px">Click here to join.</a>
    </div>
</body>
</html>