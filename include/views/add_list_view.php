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
            <a id="goBack" href="/lists/">< my lists</a>
            <div id="options">
                <a href="/lists/create" class="button"><span class="pen icon"></span>Create a new list</a>
            </div>
            <h1> Add a List to your profile page</h1>
            <ul>
                <?php foreach ($data['lists'] as $list) : ?>
                <li>
                    <div id="add"><a href = "/?controller=ListController&function=activateList&list=<?php echo $list['list']->getID(); ?>" class="button"><span class="plus icon"></span>Add this list to my profile</a></div>
                    <h2><?php echo $list['list']->getName(); ?></h2>
                    <?php if ($list['createdBy']) : ?>
                    <div id="createdBy">Created by <a href="<?php echo $list['createdBy']->getPath(); ?>"><?php echo $list['createdBy']->getHandle(); ?></a></div>
                    <?php endif; ?>
                    <?php if ($list['list']->getDescription()) : ?>
                    <p><?php echo $list['list']->getDescription(); ?></p>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php include ROOT_PATH . '/include/views/footer.php'; ?>
    </div>
</body>
</html>
