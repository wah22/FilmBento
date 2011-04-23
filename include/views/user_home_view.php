<!DOCTYPE html>
<html lang="en">
<head>
    <title>Filmbento / Home</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type ="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/humanity/jquery-ui.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include ROOT_PATH . '/include/views/header.php'; ?>
        <div id="whatSeen">
            <h1>what have you seen?</h1>
            <form method="POST" action="">
                <input type ="hidden" name="function" value="seen">
                <input type="text" name ="film" id="tags">
                <input type="submit" id="goButton" disabled="true" value="Go">
            </form>
            <div id="add">
                 Can't find? <a href="/?controller=AddFilmController">Add a film.</a>
            </div>
        </div>
        <div id="haveYouSeen">
            <h2>Recently Added - have you seen?</h2>
            <ul>
                <?php foreach ($data['recentlyAddedFilms'] as $film) : ?>
                <li>
                    <a href="<?php echo $film['film']->getPath(); ?>">
                        <?php if ($film['film']->getMeta('poster_link')) : ?>
                        <img class="poster" src="<?php echo $film['film']->getMeta('poster_link'); ?>">
                        <?php endif; ?>
                        <?php echo $film['film']->getTitle(); ?>
                    </a>
                    <p>
                    <?php for($i = 0; $i < $film['averageRating']; $i++ ) : ?>
                    <img class="star" src="/images/stars/star_filled.png">
                    <?php endfor; ?>
                    </p>
                    <?php if (!empty($film['recentSeens'])) : ?>
                    <?php foreach ($film['recentSeens'] as $seen) : ?>
                    <div class="tweeview">
                        &ldquo;<?php echo $seen['seen']->getTweeview(); ?>&rdquo;
                        <div class="signature">
                            <a href="<?php echo $seen['user']->getPath(); ?>">- <?php echo $seen['user']->getHandle(); ?></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="list">
            <h2>Recently Seen</h2>
            <ul>
                <?php foreach($data['recentlySeens'] as $seen) : ?>
                <li>
                    <a href="<?php echo $seen['user']->getPath(); ?>"><?php echo $seen['user']->getHandle(); ?></a> saw
                    <a href="<?php echo $seen['film']->getpath(); ?>"><?php echo $seen['film']->getTitle(); ?></a>
                    <?php if ($seen['seen']->getRating()) : ?>
                    and rated it <?php echo $seen['seen']->getRating(); ?> stars.
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php include ROOT_PATH . "/include/views/footer.php"; ?>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $('#whatSeenForm').submit(function() {
                if ($('#tags').val() == "") {
                    return false;
                }
            })

            $( "#tags" ).autocomplete({

                minLength: 3,

                source: function(req, add){
                            var term = req.term;

                            var url = "/?controller=API&function=search&query=" + term;

                            $.getJSON(url, function(data) {
                                  var suggestions = [];
                                  $.each(data, function(i,item){
                                    suggestions.push(item);
                                 });
                                 add(suggestions);
                            })
                        }

            });

            $('#tags').keyup(function() {
                if ($('#tags').val() != "") {
                    $("#goButton").removeAttr('disabled');
                } else {
                    $('#goButton').attr("disabled", "true");
                }
            });
        });
    </script>
</body>
</html>
