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

    <?php if (isset($data['reset'])) : ?>
    <div id="errors"><p>An email has been sent to you with your new password.</p></div>
    <?php else : ?>
    <form action="" method="post">
        <fieldset>
            <legend>Reset my password</legend>
            <label for="email">My email address</label>
            <input type="email" name="email">
            <input type="submit">
        </fieldset>
    </form>
    <?php if (isset($data['errors'])) : ?>
    <div id="errors">
        <?php echo $data['errors']; ?>
    </div>
    <?php endif ?>
    <?php endif; ?>
    
    <?php include "footer.php"; ?>
</body>
</html>
