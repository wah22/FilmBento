<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
    <title></title>
   <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <?php include("header.php"); ?>

    <h1>Manage my account</h1>

    <div id="accountSettings">
        <form method="post" action="/?controller=AccountSettingsController&function=save">
            <fieldset>
                <legend>my credentials</legend>
                <p>
                    <label for="email">email</label>
                    <input type="email" value="<?php echo $data['user']->getEmail(); ?>" name="email">
                </p>
                <p>
                    <label for="email">password</label>
                    <input type="password" name="password">
                </p>
                <input type="submit" value="Save">
            </fieldset>
        </form>

        <form>
            <fieldset>
                <legend>my avatar</legend>
                <p>FilmBento uses <a href="http://en.gravatar.com/">Gravatar</a> for avatars.</p>
                <p>You can set or change your avatar there.</p>
                <div class="notes">
                    <p>Currently using <?php echo $data['user']->getEmail(); ?></p>
            </fieldset>
        </form>

        <form>
            <fieldset>
                <legend>delete my account</legend>
                <p>Wanna get rid of your FilmBento page?</p>
                <p>You'll lose everything and stuff.</p>
                <input type="hidden" name="controller" value="AccountSettingsController">
                <input type="hidden" name="function" value="deleteAccount">
                <input type="submit" value ="Delete Account">
            </fieldset>
        </form>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
