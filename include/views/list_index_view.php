<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
   <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/smoothness/jquery-ui.css">
 </head>
 <body>
     <?php include ("header.php"); ?>
     <?php include('navbar.php'); ?>

    <?php foreach ($data['user']->getLists() as $list) :  ?>

    <a href="/?controller=ListController&function=edit&list=<?php echo $list->getID(); ?>"><?php echo $list->getName(); ?></a><br>

    <?php endforeach; ?>

 </body>
 </html>

