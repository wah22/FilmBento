<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmBento/Join</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include ("header.php"); ?>
        <div id="join">
            <h1>Create a page</h1>
            <form method="post" action="">
                <fieldset>
                    <label for="email">your email address</label>
                    <input type="email" name="email">
                    <div class="notes">
                        <p>Your email address will be kept Top Secret.</p>
                    </div>
                </fieldset>
                <fieldset>
                    <p>
                        <label for="password">choose a password</label>
                        <input type="password" name="password">
                    </p>

                    <p>
                        <label for="password2">confirm your password</label>
                        <input type="password" name="password2">
                    </p>
                </fieldset>
                <fieldset>
                    <label for="handle">your name</label>
                    <input type="text" name="handle">
                    <div class="notes">
                        <p>This is the name that will appear in your URL. (http://www.filmbento.com/you)</p>
                        <p>It can be 3-64 lowercase letters or numbers, with no punctuation or spaces.</p>
                    </div>
                </fieldset>
                <!--
                <fieldset>
                    <div class="notes">
                        <p>Avatars in FilmBento are provided by Gravatar</p>
                    </div>
                    <label style="display: inline" for="gravatar">Include your Gravatar on your page?</label>
                    <input style ="margin-bottom: 20px" type="checkbox" name="gravatar">
                </fieldset>
                -->
                <input type ="submit" value ="Join">
                <input type="hidden" name="controller" value="JoinController">
                <input type="hidden" name="function" value="submit">
            </form>

            <div id="errors">
                <?php if (isset($data['errors'])) : ?>
                    <?php foreach ($data['errors'] as $error) : ?>
                        <?php echo $error; ?><br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php include "footer.php"; ?>
    </div>
</body>
</html>
