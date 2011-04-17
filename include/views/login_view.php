<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmBento / Log In</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include("header.php"); ?>
        <div id="logIn">
            <form method="POST" action="">
                <fieldset>
                    <legend>Log In</legend>
                    <label for="identifier">username</label>
                    <input type="text" name="identifier">

                    <label for="password">password</label>
                    <input type="password" name="password">
                    <input type="submit" value="Log in">

                    <input type="hidden" name="controller" value="LoginController">
                    <input type="hidden" name="function" value="login">
                </fieldset>
            </form>
            <div id="forgotPassword">
                <a href="<?php echo BASE_URL; ?>/forgotPassword">Forgot my password</a>
            </div>

            <div id="errors">
                <?php foreach ($data['errors'] as $error) : ?>
                    <?php echo $error; ?><br>
                <?php endforeach; ?>
            </div>
        </div>
        <?php include "footer.php"; ?>
    </div>
</body>
</html>
