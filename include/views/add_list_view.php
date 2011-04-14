<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmBento / Add a List</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include ROOT_PATH . '/include/views/header.php'; ?>
        <div id="addList">

            <ul>
                <?php foreach ($data['lists'] as $list) : ?>
                <li>
                    <a href = "/?controller=ListController&function=activateList&list=<?php echo $list->getID(); ?>">Add</a>
                    <h2><?php echo $list->getName(); ?><h2>
                    <p><?php //echo $list->getDescription(); ?></p>
                </li>
                <?php endforeach; ?>
            </ul>

        </div>
        <?php include ROOT_PATH . '/include/views/footer.php'; ?>
    </div>
</body>
</html>
