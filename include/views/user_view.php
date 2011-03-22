<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
   <link rel="stylesheet" type="text/css" href="/css/user.css">
 </head>
 <body>
     <?php include ("header.php"); ?>

     <div id="userProfile">
        <h1><?php echo $data['user']->getHandle(); ?></h1>

        <div class="list">
            <h1><?php echo $data['user']->getHandle(); ?> has seen</h1>
            <ul>
                <?php foreach ( $data['user']->getSeens(10) as $seen ) : ?>
                <li>
                    <div class="title">
                        <a href='<?php echo $seen->getFilm()->getPath(); ?>'><?php echo $seen->getFilm()->getTitle(); ?></a>
                    </div>

                    <div class="rating">
                        <?php for ( $i = 0 ; $i < $seen->getRating(); $i++ ) : ?>
                        <img src="/images/stars/star_filled.png">
                        <?php endfor; ?>
                    </div>

                    <div class="whenSeen"><?php echo $seen->whenSeen(); ?></div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>


        <?php foreach ($data['user']->getLists() as $list) : ?>
            <?php //if (!empty( $list->getSeens() ) ) : ?>
                <div class="list">
                    <h1><?php echo $list->getName(); ?><br></h1>
                    <ul>
                        <?php foreach ($list->getSeens() as $seen) : ?>
                            <li><a href='<?php echo $seen->getFilm()->getPath(); ?>'><?php echo $seen->getFilm()->getTitle(); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php // endif; ?>
        <?php endforeach; ?>
     </div>
     
     <?php include "footer.php"; ?>
</body>
</html>
