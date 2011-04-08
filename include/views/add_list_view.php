<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
    <title></title>
   <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include("header.php"); ?>
        <div id="addList">

            <ul>
                <?php foreach ($data['lists'] as $list) : ?>
                <li>
                    <a href = "/?controller=ListController&function=activateList&list=<?php echo $list->getID(); ?>"><img src="/images/icons/add.png"></a>
                    <h2><?php echo $list->getName(); ?><h2>
                    <p><?php //echo $list->getDescription(); ?></p>
                </li>
                <?php endforeach; ?>
            </ul>

        </div>
        <?php include "footer.php"; ?>
    </div>
</body>
</html>
