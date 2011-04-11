<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmBento/Create New List</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="icon" href="images/favicon.png" type="image/png">
</head>
<body>
    <div id="pageWrapper">
        <?php include ROOT_PATH . '/include/views/header.php'; ?>
        <h1>Create a New List</h1>
        <form method="post" action="">
            <fieldset>
                <label for="name">list name</label>
                <input type="text" name="name">
                <label for="maxEntries">Max number of entries on the list</label>
                <select name="maxEntries">
                    <?php for ($i = 3; $i < 10; $i++) : ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                    <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <option value="<?php echo $i*10; ?>"><?php echo $i*10; ?></option>
                    <?php endfor; ?>
                </select>
                <input type="submit" name="submit" value="Create">
            </fieldset>
        </form>
        <?php include ROOT_PATH . '/include/views/footer.php'; ?>
    </div>
</body>
</html>
