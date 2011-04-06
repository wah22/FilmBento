<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type ="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/humanity/jquery-ui.css">
 </head>
 <body>
    <div id="pageWrapper">
        <?php include("header.php"); ?>

        <div id="whatSeen">
            <h1>what have you seen?</h1>

            <form method="POST" action="/" id="whatSeenForm">
                <input type ="hidden" name="function" value="seen">
                <input type="text" name ="film" id="tags"><br>
                <input type="submit" value="Go" id="goButton" disabled="true">
            </form>

            <div id="add">
                 Not here? <a href="/?controller=AddFilmController">Add a film.</a>
            </div>
        </div>

        <div class="list">
            <h2>Recently Added</h2>
            <ul>
                <?php foreach ($data['recentlyAddedFilms'] as $film) : ?>
                <li><a href="<?php echo $film->getPath(); ?>"><?php echo $film->getTitle(); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php include "footer.php"; ?>
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
