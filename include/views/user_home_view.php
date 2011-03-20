<!DOCTYPE html>
 <html lang="en">
 <head>
   <title></title>
   <link href='http://fonts.googleapis.com/css?family=Ubuntu:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
   <link rel="stylesheet" type ="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/humanity/jquery-ui.css">
 </head>
 <body>
     <?php include("header.php"); ?>

     <div id="whatSeen">
        <h1>what have you seen?</h1>

        <form method="POST" action="/">
            <input type ="hidden" name="function" value="seen">
            <input type="text" name ="film" id="tags"><br>
            <input type="submit" value="&#62;" id="goButton" disabled="true">
        </form>

        <div id="add">
             Not here? <a href="/?controller=AddFilmController">Add a film.</a>
        </div>
    </div>
    <?php include "footer.php"; ?>
 </body>
 </html>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script>
    $(function() {

        $( "#tags" ).autocomplete({

            source: function(req, add){
                        var term = req.term;

                        var url = "/?controller=FilmController&function=search&query=" + term;

                        $.getJSON(url, function(data) {
                              var suggestions = [];
                              $.each(data, function(i,item){
                                suggestions.push(item);
                             });
                             add(suggestions);
                        })
                    }

            });

            $('#tags').change(function() {
                if ($('#tags').val() != "") {
                    $("#goButton").removeAttr('disabled');
                } else {
                    $('#goButton').attr("disabled", "true");
                }
            });
    });
</script>