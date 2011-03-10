<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
 </head>
 <body>

     <?php include "header.php" ?>

    Title: <a href = '<?php echo $data['film']->getPath(); ?>'> <?php echo $data['film']->getTitle(); ?> </a> <br>

    The users who have seen <?php echo $data['film']->getTitle(); ?> are:<br>

    <?php foreach($data['film']->getSeens() as $seen) : ?>
    <a href='<?php echo $seen->getUser()->getPath(); ?>'><?php echo $seen->getUser()->getHandle(); ?></a><br>
    <?php endforeach; ?>

    <?php if (!$data['user']->hasSeen($data['film'])) : ?>
    <a href='/?controller=FilmController&film=<?php echo $data['film']->getTitle(); ?>&function=seen'>seen</a>
    <?php endif; ?>

 </body>
 </html>