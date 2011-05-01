<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmBento / Edit: <?php echo $data['film']->getTitle(); ?></title>
   <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include("header.php"); ?>
        <div id=editFilm>
            <form action="" method="post" autocomplete=Off>
                <fieldset>
                    <legend>Title</legend>
                    <?php echo $data['film']->getTitle(); ?>
                </fieldset>
                <fieldset>
                    <legend>Details</legend>

                    <label for="year">Year</label>
                    <input type="text" name="year" value="<?php echo $data['film']->getYear(); ?>">

                    <label for="posterLink">Poster URL</label>
                    <input type="text" name="posterLink" id="posterURL" value="<?php echo $data['film']->getMeta('poster_link'); ?>">

                    <label for="wikiLink">Hashtag</label>
                    <span class=hash>#</span><input type="text" name="hashtag" value="<?php echo $data['film']->getMeta('hashtag'); ?>">
                </fieldset>

                <fieldset id=URLs>
                    <legend>External URLs</legend>
                    <label for="wikiLink">Wikipedia Link</label>
                    <input type="text" name="wikiLink" value="<?php echo $data['film']->getMeta('wiki_link'); ?>">
                    <label for="rtLink">Rotten Tomatoes Link</label>
                    <input type="text" name="rtLink" value="<?php echo $data['film']->getMeta('rt_link'); ?>">
                    <label for="imdbLink">IMDb Link</label>
                    <input type="text" name="imdbLink" value="<?php echo $data['film']->getMeta('imdb_link'); ?>">
                    <label for="metacriticLink">Metacritic Link</label>
                    <input type="text" name="metacriticLink" value="<?php echo $data['film']->getMeta('metacritic_link'); ?>">
                </fieldset>
                
                <input type="submit" name="submit" value="Save">
            </form>
            <?php include "footer.php"; ?>
        </div>
    </div>
</body>
</html>

