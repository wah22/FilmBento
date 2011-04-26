<!DOCTYPE html>
 <html lang="en">
 <head>
    <title>FilmBento / Admin</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include ("header.php"); ?> 
            <div id=admin>
                <div id=goBack>
                    <a href="<?php echo BASE_URL; ?>/admin">admin home</a>
                </div>
                <h1>Admin / Site Settings</h1>

                <form action="<?php echo BASE_URL; ?>/admin/site_settings" method="post">
                    <label for=disallowed_handles>Disallowed Handles</label>
                    <input type=text value="<?php echo $data['site_settings']['disallowed_handles']; ?>" name="disallowed_handles">
                    Enter the disallowed usernames/handles here, separated by semicolons.
                    <input type=submit value=Submit name=submit>
                </form>
            </div>
        <?php include "footer.php"; ?>
    </div>
</body>
</html>
