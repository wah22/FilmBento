<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmBento / Add a Film</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <div id="pageWrapper">

        <?php require_once 'header.php'; ?>

        <div id="addFilm">
            <h1>Add a Film</h1>

            <form method="POST" action="">
                <fieldset>
                    <fieldset>
                        <legend>Details</legend>
                        <input type="hidden" name="function" value="addFilm">
                        
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text">

                        <label for="year">Year</label>
                        <input id="year" name="year" type="text">

                        <label for="poster_url">Poster URL</label>
                        <input id="poster_url" name="poster_url" type="text">

                        <label for="hashtag">Hashtag</label>
                        <input id="hashtag" name="hashtag" type="text">
                    </fieldset>

                    <fieldset>
                        <legend>External URLs</legend>
                        <label for="wiki_link">Wikipedia</label>
                        <input id="wiki_link" name="wiki_link" type="text">

                        <label for="rt_link">Rotten Tomatoes</label>
                        <input id="rt_link" name="rt_link" type="text">

                        <label for="imdb_link">IMDb</label>
                        <input id="imdb_link" name="imdb_link" type="text">

                        <label for="metacritic_link">Metacritic</label>
                        <input id="metacritic_link" name="metacritic_link" type="text">
                    </fieldset>

                    <div class="notes">
                        <p>Please make sure the info you enter is correct.</p>
                    </div>
                    <?php if (!empty($data['errors'])) : ?>
                    <div id="errors">
                        <?php foreach($data['errors'] as $error) : ?>
                        <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <button name="submit" class="big button"><span class="check icon"></span>Add</button>
                </fieldset>
            </form>
        </div>

        <?php include "footer.php"; ?>
    </div>
 </body>
 </html>
