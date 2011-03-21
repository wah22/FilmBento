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

    <div id="logIn">
        <form method="POST" action="">

            <label for="identifier">username</label>
            <input type="text" name="identifier"><br>

            <label for="password">password</label>
            <input type="password" name="password"><br>
            <input type="submit" value="Log in">

            <input type="hidden" name="controller" value="LoginController">
            <input type="hidden" name="function" value="login">
        </form>

        <div id="errors">
            <?php foreach ($data['errors'] as $error) : ?>
                <?php echo $error; ?><br>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>
