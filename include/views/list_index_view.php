<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
   <link rel="stylesheet" type ="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/humanity/jquery-ui.css">
 </head>
 <body>
    <?php include ("header.php"); ?>

     <div id="top10"></div>
     <div id="ever"></div>

    <?php include "footer.php"; ?>
 </body>
 </html>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script>
$(function() {
        $('#top10').load('http://localhost:4492/?controller=ListController&function=edit&list=1');
        $('#ever').load('http://localhost:4492/?controller=ListController&function=edit&list=2');
});
</script>
