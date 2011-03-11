<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
   <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/smoothness/jquery-ui.css">
 </head>
 <body>
     <?php include("header.php"); ?>

     <div id="whatSeen">
        <h1>what have you seen?</h1>

        <form method="POST" action="/">
            <input type ="hidden" name="function" value="seen">
            <input type="text" name ="film" id="tags"><br>
            <input type="submit">
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
            var availableTags = <?php echo json_encode($data['films']); ?>;
            $( "#tags" ).autocomplete({
                    source: availableTags
            });
    });
</script>