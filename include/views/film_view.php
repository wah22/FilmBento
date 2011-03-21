<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
 </head>
 <body>
     <?php include "header.php" ?>

     <div id="film">

        <h1><?php echo $data['film']->getTitle(); ?></h1>

        <?php if ($data['user']->hasSeen($data['film']) && !$data['user']->hasRated($data['film'])) : ?>

            <div id="rate">
                <?php for( $i = 1; $i <= 5 ; $i++ ) : ?>
                <form method="post" action="">
                    <input type="hidden" name="function" value="rate">
                    <input type="hidden" name="film" value="<?php echo $data['film']->getID(); ?>">

                    <input type="image" name="rating" value="<?php echo $i; ?>" src="/images/stars/star_empty.png" style="float:left">
                </form>
                <?php endfor; ?>
            </div>

        <?php elseif ($data['user']->hasRated($data['film'])) : ?>

            <div id="rate">

                <?php for( $i = 0 ; $i < $data['user']->getRatingOf($data['film']) ; $i++ ) : ?>
                    <img src="/images/stars/star_filled.png">
                <?php endfor; ?>

            </div>
        
        <?php endif; ?>

        <div class="list">
            <h1>Recently seen by</h1>
            <?php foreach($data['film']->getSeens() as $seen) : ?>
            <p><a href="<?php echo $seen->getUser()->getPath(); ?>"><?php echo $seen->getUser()->getHandle(); ?></a></p>
            <?php endforeach; ?>
        </div>

        <?php if (!$data['user']->hasSeen($data['film'])) : ?>
        <form method="post" action="">
            <input type="hidden" name="function" value="seen">
            <input type="hidden" name="film" value="<?php echo $data['film']->getID(); ?>">
            <input type ="submit" value="Seen it">
        </form>
       <?php endif; ?>

     </div>

    <?php include "footer.php"; ?>
 </body>
 </html>

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
