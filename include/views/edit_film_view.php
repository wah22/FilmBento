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

    <form action="" method="post">
        <fieldset>
            <legend>Title</legend>
            <?php echo $data['film']->getTitle(); ?>
        </fieldset>
        <fieldset>
            <label for="year">Year</label>
            <input type="text" name="year" value="<?php echo $data['film']->getYear(); ?>">
        </fieldset>
        <input type="submit">
    </form>
    
    <?php include "footer.php"; ?>
</body>
</html>
