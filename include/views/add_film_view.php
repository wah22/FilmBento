<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link href='http://fonts.googleapis.com/css?family=Ubuntu:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
 </head>
 <body>
     <?php require_once 'header.php'; ?>

     <h1>add a film<h1>

     <form id="addFilm" method="POST" action="">
         <input type="hidden" name="function" value="addFilm">
         <label for="title">Title</label>
         <input id="title" name="title" type="text">
         <input type="submit">
     </form>
     <?php include "footer.php"; ?>
 </body>
 </html>