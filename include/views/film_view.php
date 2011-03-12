<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link href='http://fonts.googleapis.com/css?family=Ubuntu:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
 </head>
 <body>
     <?php include "header.php" ?>

     <div id="film">

        <h1><?php echo $data['film']->getTitle(); ?></h1>

        <?php if ($data['user']->hasSeen($data['film']) && !$data['user']->hasRated($data['film'])) : ?>

        <form id="rating" method="post" action="">
            1<input type="radio" name="rating" value="1">
            2<input type="radio" name="rating" value="2">
            3<input type="radio" name="rating" value="3">
            4<input type="radio" name="rating" value="4">
            5<input type="radio" name="rating" value="5">

            <input type="hidden" name="function" value="rate">
            <input type="hidden" name="film" value="<?php echo $data['film']->getTitle(); ?>">

            <input type="submit">
        </form>

        <?php else : ?>

        <p>You rated this film <?php echo $data['user']->getRatingOf($data['film']); ?></p>

        <?php endif; ?>

        <div class="list">
            <h1>Recently seen by</h1>

            <?php foreach($data['film']->getSeens() as $seen) : ?>
            <a href='<?php echo $seen->getUser()->getPath(); ?>'><?php echo $seen->getUser()->getHandle(); ?></a><br>
            <?php endforeach; ?>
        </div>

        <?php if (!$data['user']->hasSeen($data['film'])) : ?>
        <a href='/?controller=FilmController&film=<?php echo $data['film']->getTitle(); ?>&function=seen'>I've seen this</a>
        <?php endif; ?>

     </div>

    <?php include "footer.php"; ?>
 </body>
 </html>
