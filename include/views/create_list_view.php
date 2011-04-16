<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmBento / Create New List</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include ROOT_PATH . '/include/views/header.php'; ?>
        <h1>Create a New List</h1>
        <form method="post" action="/?controller=ListController&function=create">
            <fieldset>
                <label for="name">list name</label>
                <input type="text" name="name">
                <label for="maxEntries">Max number of entries on the list</label>
                <select name="maxEntries">
                    <option value="3">3</option>
                    <option value="5">5</option>
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <option value="<?php echo $i*10; ?>"><?php echo $i*10; ?></option>
                    <?php endfor; ?>
                    <option value="100">100</option>
                    <option value="0">Unlimited</option>
                </select>
                <label for="description">Description</label>
                <input type="text" name="description">
                <input type="submit" name="submit" value="Create">
            </fieldset>
        </form>
        <?php include ROOT_PATH . '/include/views/footer.php'; ?>
    </div>
</body>
</html>
