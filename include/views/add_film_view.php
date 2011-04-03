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

        <?php require_once 'header.php'; ?>

        <div id="addFilm">
            <h1>Add a Film</h1>

            <form method="POST" action="">
                <input type="hidden" name="function" value="addFilm">

                <fieldset>
                    <legend>Required Info</legend>
                    <p>
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text">
                    </p>
                    <p>
                        <label for="year">Year</label>
                        <input id="year" name="year" type="text">
                    </p>
                    <div class="notes">
                        <p>Please make sure the info you enter is correct.</p>
                        <p>Google it if you have to.</p>
                    </div>
                </fieldset>

                <fieldset id="links">
                    <legend>Optional Info</legend>
                    <p>
                        <label for="wikiLink">Wikipedia Link</label>
                        <input type="text" name="wikiLink">
                    </p>
                    <p>
                        <label for="rtLink">Rotten Tomatoes Link</label>
                        <input type="text" name="rtLink">
                    </p>
                </fieldset>
                    <input type="submit" value="Add">
                </p>
            </form>
        </div>

        <?php include "footer.php"; ?>
    </div>
 </body>
 </html>
