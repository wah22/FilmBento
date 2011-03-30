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

    <div id="accountSettings">
        <form method="post" action="/?controller=AccountSettingsController&function=save">
            <fieldset>
                <h2>your credentials</h2>
                <p>
                    <label for="email">email</label>
                    <input type="email" value="<?php echo $data['user']['email'];?>" name="email">
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
                <h2>delete my account</h2>
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
