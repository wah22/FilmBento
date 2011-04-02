<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
   <link rel="stylesheet" type="text/css" href="/css/film.css">
 </head>
 <body>
    <?php include "header.php" ?>
     
    <div id="film">
        <h1><?php echo $data['film']->getTitle(); ?></h1>
        <h2>(<?php echo $data['film']->getyear(); ?>)</h2>
        
        <?php if (!$data['hasSeen']) : ?>
        <form method="post" action="">
            <input type="hidden" name="function" value="seen">
            <input type="hidden" name="film" value="<?php echo $data['film']->getID(); ?>">
            <input type ="submit" value="Seen it" id="seenIt">
       </form>
       <?php endif; ?>

        <?php if ($data['hasSeen']) : ?>
        <div id="rate">
            <fieldset>
                <legend>Seen</legend>
                <?php echo $data['whenSeen']; ?>
                <form method="post" action="" id="unSee">
                    <input type="hidden" name="function" value="unsee">
                    <input type="hidden" name="film" value="<?php echo $data['film']->getID(); ?>">
                    <input type ="submit" value="X">
               </form>
            </fieldset>
            <fieldset>
                <legend>My rating</legend>
                <?php for( $i = 1; $i <= 5 ; $i++ ) : ?>
                <form method="post" action="">
                        <input type="hidden" name="function" value="rate">
                        <input type="hidden" name="film" value="<?php echo $data['film']->getID(); ?>">
                        <input type="hidden" name="rating" value="<?php echo $i; ?>">
                        <?php if ($data['hasRated'] && $i <= $data['rating']) : ?>
                        <input type="image" name="rating" value="<?php echo $i; ?>" src="/images/stars/star_filled.png" style="float:left">
                        <?php else : ?>
                        <input type="image" name="rating" value="<?php echo $i; ?>" src="/images/stars/star_empty.png" style="float:left">
                        <?php endif; ?>
                </form>
                <?php endfor; ?>
            </fieldset>
        </div>
        <?php endif; ?>

        <div class="list">
            <h1>Recently seen by</h1>
            <?php foreach($data['recentlySeens'] as $seen) : ?>
            <p><a href="<?php echo $seen['path']; ?>"><?php echo $seen['user']; ?></a></p>
            <?php endforeach; ?>
        </div>
     </div>

    <?php include "footer.php"; ?>
 </body>
 </html>
 