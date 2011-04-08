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
     <div id="pageWrapper">

        <?php include "header.php" ?>

        <div id="film">
            <div id="details">
                <p>Added by <a href="<?php echo $data['addedBy']->getPath(); ?>"><?php echo $data['addedBy']->getHandle(); ?></a></p>
                <?php if($data['user']) : ?>
                <a href="/?controller=FilmController&film=<?php echo urlencode($data['film']->getTitle()); ?>&function=edit">edit/add details</a>
                <?php endif; ?>
            </div>

            <?php if ($data['film']->getMeta('poster_link')) : ?>
            <img src="<?php echo $data['film']->getMeta('poster_link'); ?>" style="height: 270px; position: absolute;">
            <?php endif; ?>

            <h1><?php echo $data['film']->getTitle(); ?></h1>
            <h2>(<?php echo $data['film']->getyear(); ?>)</h2>

            <div id="links">
                <ul>
                <?php if ($data['film']->getMeta('wiki_link')) : ?>
                    <li>
                        <a href="<?php echo $data['film']->getMeta('wiki_link'); ?>">Wikipedia</a>
                    </li>
                <?php endif; ?>

                <?php if ($data['film']->getMeta('rt_link')) : ?>
                    <li>
                        <a href="<?php echo $data['film']->getMeta('rt_link'); ?>">Rotten Tomatoes</a>
                    </li>
                <?php endif; ?>

                <?php if ($data['film']->getMeta('imdb_link')) : ?>
                    <li>
                        <a href="<?php echo $data['film']->getMeta('imdb_link'); ?>">IMDb</a>
                    </li>
                <?php endif; ?>

                <?php if ($data['film']->getMeta('metacritic_link')) : ?>
                    <li>
                        <a href="<?php echo $data['film']->getMeta('metacritic_link'); ?>">Metacritic</a>
                    </li>
                <?php endif; ?>
                </ul>
            </div>

            <?php if($data['user']) : ?>

            <?php if (!$data['hasSeen']) : ?>
            <form method="post" action="">
                <input type="hidden" name="function" value="seen">
                <input type="hidden" name="film" value="<?php echo $data['film']->getID(); ?>">
                <input type ="submit" value="Seen it" id="seenIt">
           </form>
           <?php endif; ?>

            <?php if ($data['hasSeen']) : ?>
            <div id="rate">
                <fieldset id ="seen">
                    <legend>Seen</legend>
                    <?php echo $data['whenSeen']; ?>
                    <form method="post" action="" id="unSee">
                        <input type="hidden" name="function" value="unsee">
                        <input type="hidden" name="film" value="<?php echo $data['film']->getID(); ?>">
                        <input type ="image" src="/images/icons/x.png">
                   </form>
                </fieldset>
                <fieldset>
                    <legend>My rating</legend>
                    <?php for( $i = 1; $i <= 5 ; $i++ ) : ?>
                    <form method="post" action="">
                        <input type="hidden" name="function" value="rate">
                        <input type="hidden" name="rating" value="<?php echo $i; ?>">
                        <?php if ($data['hasRated'] && $i <= $data['rating']) : ?>
                        <input type="image" name="rating" value="<?php echo $i; ?>" src="/images/stars/star_filled.png" style="float:left">
                        <?php else : ?>
                        <input type="image" name="rating" value="<?php echo $i; ?>" src="/images/stars/star_empty.png" style="float:left">
                        <?php endif; ?>
                    </form>
                    <?php endfor; ?>
                    <br>

                    <?php if (empty($data['tweeview'])) : ?>
                    <a href="#" id="showTweeview">
                        <img src="/images/icons/comment_add.png">write tweeview
                    </a>
                    <div id="tweeview">
                        <form method="post" action="">
                            <input type="hidden" name="function" value="tweeview">
                            <textarea name="tweeview" rows="7" maxlength="140"></textarea>
                            <input type="submit" name="submit" value="Submit">
                        </form>
                    </div>
                    <?php else : ?>
                    <div id="tweeviewShown"><?php echo $data['tweeview']; ?></div>
                    <?php endif; ?>
                </fieldset>
            </div>
            <?php endif; ?>
            <?php endif; ?>

            <div class="list" id="recentlySeen">
                <h1>Recently seen by</h1>
                <ul>
                    <?php foreach($data['recentlySeens'] as $seen) : ?>
                    <li>
                        <h2><a href="<?php echo $seen['path']; ?>"><?php echo $seen['user']; ?></a></h2>
                        <div id="stars">
                            <?php for ($i = 0; $i < $seen['rating']; $i++) : ?>
                            <img src="/images/stars/star_filled.png">
                            <?php endfor; ?>
                        </div>
                        <p><?php echo $seen['tweeview']; ?></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php if ($data['film']->getMeta('hashtag')) : ?>
            <div id="twitter">
                <script src="http://widgets.twimg.com/j/2/widget.js"></script>
                <script>
                new TWTR.Widget({
                  version: 2,
                  type: 'search',
                  search: '<?php echo "#", $data['film']->getMeta('hashtag'); ?>',
                  interval: 6000,
                  //title: 'What people are saying about',
                  subject: '<?php echo '#' , $data['film']->getMeta('hashtag'); ?>',
                  width: 'auto',
                  height: 'auto',
                  theme: {
                    shell: {
                      background: '#8ec1da',
                      color: '#ffffff'
                    },
                    tweets: {
                      background: '#ffffff',
                      color: '#444444',
                      links: '#1985b5'
                    }
                  },
                  features: {
                    scrollbar: true,
                    loop: true,
                    live: true,
                    hashtags: true,
                    timestamp: true,
                    avatars: true,
                    toptweets: true,
                    behavior: 'default'
                  }
                }).render().start();
                </script>
             </div>
            <?php endif; ?>
        </div>
        <?php include "footer.php"; ?>
     </div>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
     <script type="text/javascript">
         $(function() {
            $('#tweeview').hide();

            $('#showTweeview').click(function(){
                $('#tweeview').slideToggle(230);
            });
         });
     </script>
 </body>
 </html>
 