<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
     <?php include ("header.php"); ?>

    <div id="join">
        <form method="post" action="">

            <label for="email">your email address</a>
            <input type="text" name="email">

            <label for="password">choose a password</a>
            <input type="password" name="password">

            <label for="password2">confirm your password</a>
            <input type="password" name="password2">

            <label for="handle">choose your name</a>
            <input type="text" name="handle">
            
            <input type ="submit" value ="Join">

            <input type="hidden" name="controller" value="JoinController">
            <input type="hidden" name="function" value="submit">
        </form>

        <div id="errors">
            <?php foreach ($data['errors'] as $error) : ?>
                <?php echo $error; ?><br>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>