<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
 </head>
 <body>
     <div id="userProfile">
        <?php include ("header.php"); ?>
        <?php include('navbar.php'); ?>

        <h1><a href='<?php echo $data['user']->getPath(); ?>'><?php echo $data['user']->getHandle(); ?></a></h1>

        <div class="list">
            <h1><?php echo $data['user']->getHandle(); ?> has seen<br></h1>
            <ul>
                <?php foreach ( $data['user']->getSeens() as $seen ) : ?>
                <li><a href='<?php echo $seen->getFilm()->getPath(); ?>'><?php echo $seen->getFilm()->getTitle(); ?></a><br></li>
                <?php endforeach; ?>
            </ul>
        </div>


        <?php foreach ($data['user']->getLists() as $list) : ?>
            <div class="list">
                <h1><?php echo $list->getName(); ?><br></h1>
                <ul>
                    <?php foreach ($list->getSeens() as $seen) : ?>
                        <li><?php echo $seen->getFilm()->getTitle(); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
     </div>
</body>
</html>