<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>FilmBento / <?php echo $data['film']->getTitle(); ?></title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
 </head>
 <body>
     <div id="pageWrapper">
        <?php include ROOT_PATH . '/include/views/header.php'; ?>
        <div id="film">
            <div id="leftColumn">
                <ul>
                    <li>
                        <?php if ($data['film']->getMeta('poster_link')) : ?>
                        <img id="poster" src="<?php echo $data['film']->getMeta('poster_link'); ?>">
                        <?php endif; ?>
                    </li>
                    <li>
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
                    </li>
                    <li>
                        <?php if ($data['film']->getMeta('hashtag')) : ?>
                        <div id="twitter">
                            <script src="http://widgets.twimg.com/j/2/widget.js" type="text/javascript"></script>
                            <script type="text/javascript">
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
                    </li>
                </ul>
            </div>

            <div id="mainColumn">
                <div id=title>
                    <hgroup>
                        <h1><?php echo $data['film']->getTitle(); ?></h1>
                        <h2>(<?php echo $data['film']->getyear(); ?>)</h2>
                    </hgroup>
                    <div id="averageRating">
                            <?php for($i = 0; $i < $data['averageRating']; $i++) : ?>
                            <img src="/images/stars/star_filled.png" alt ="X">
                            <?php endfor; ?>
                    </div>
                </div>
                

                <div class="list" id="recentlySeen">
                    <h1>Recently seen by</h1>
                    <ul>
                        <?php foreach($data['recentlySeens'] as $seen) : ?>
                        <li>
                            <h3><a href="<?php echo $seen['user']->getPath(); ?>"><?php echo $seen['user']->getHandle(); ?><img id="avatar" src="<?php echo $seen['user']->getAvatar(); ?>"></a></h3>
                            <div id="stars">
                                <?php for ($i = 0; $i < $seen['rating']; $i++) : ?>
                                <img src="/images/stars/star_filled.png" alt ="X">
                                <?php endfor; ?>
                            </div>
                            <?php if (!empty($seen['tweeview'])) : ?>
                            <p><?php echo $seen['tweeview']; ?></p>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div id="rightColumn">
                <div id="details">
                    <?php if ($data['addedBy']) : ?>
                    <p>Added by <a href="<?php echo $data['addedBy']->getPath(); ?>"><?php echo $data['addedBy']->getHandle(); ?></a></p>
                    <?php endif; ?>
                    <?php if($data['user']) : ?> 
                    <a href="<?php echo $data['film']->getPath(); ?>/edit">edit/add details</a>
                    <?php endif; ?>
                </div>
                <?php if($data['user']) : ?>
                    <?php if (!$data['hasSeen']) : ?>
                    <form method="post" action="">
                        <input type="hidden" name="function" value="seen">
                        <input type="hidden" name="film" value="<?php echo $data['film']->getID(); ?>">
                        <input type ="submit" value="Seen it" id="seenIt" class="seenIt">
                    </form>
                    <?php endif; ?>
                    <?php if ($data['hasSeen']) : ?>
                        <div id ="seen">
                            <fieldset>
                                <legend>Seen</legend>
                                <?php echo $data['whenSeen']; ?>
                                <form method="post" action="" id="unSee">
                                    <input type="hidden" name="function" value="un-see">
                                    <input type="hidden" name="film" value="<?php echo $data['film']->getID(); ?>">
                                    <button class="negative button" id="unSeeButton"><span class="cross icon"></span></button>
                               </form>
                            </fieldset>
                        </div>
                        <fieldset id="rate">
                            <legend>My Rating</legend>
                            <div id="rating">
                                <?php for( $i = 1; $i <= 5 ; $i++ ) : ?>
                                <form method="post" action="" class="rateStar">
                                    <input type="hidden" name="function" value="rate">
                                    <input type="hidden" name="rating" value="<?php echo $i; ?>">
                                    <?php if ($data['hasRated'] && $i <= $data['rating']) : ?>
                                    <input type="image" name="rating" value="<?php echo $i; ?>" src="/images/stars/star_filled.png" style="float:left">
                                    <?php else : ?>
                                    <input type="image" name="rating" value="<?php echo $i; ?>" src="/images/stars/star_empty.png" style="float:left">
                                    <?php endif; ?>
                                </form>
                                <?php endfor; ?>
                            </div>
                        </fieldset>
                    <?php endif; ?>
                    <?php if ($data['hasSeen']) : ?>
                    <div id="tweeview">
                        <fieldset>
                            <legend>My Tweeview</legend>
                            <?php if (empty($data['tweeview'])) : ?>
                            <form method="post" action="">
                                <input type="hidden" name="function" value="tweeview">
                                <textarea name="tweeview" rows="3" maxlength="140"></textarea>
                                <button class=button>Submit</button>
                            </form>
                            <?php else : ?>
                            <p><?php echo $data['tweeview']; ?></p>
                            <?php endif; ?>
                        </fieldset>
                    </div>
                    <div id=tweetButton>
                        <a href="http://twitter.com/share?text=I saw <?php echo $data['film']->getTitle(); ?><?php if ($data['hasRated']) : ?> and rated it <?php echo $data['rating']; ?> stars<?php endif; ?> on %23FilmBento&url=<?php echo LoginManager::getInstance()->getLoggedInUser()->getPath(); ?>"><img src="<?php echo BASE_URL;?>/images/logos/twitter.png">Tweet</a>
                    </div>
                    <?php endif; ?>
                <?php else : ?>
                <a href="<?php echo BASE_URL; ?>/login"><input type="submit" value="Seen it" class="seenIt"></a>
                <?php endif; ?>
            </div>
        </div>
        <?php include "footer.php"; ?>
     </div>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
     <script type="text/javascript">
         $(function() {
            $('#seenIt').live('click', function(event) {
                event.preventDefault();

                var filmID = $(this).parent().find('input[name=film]').val();

                $.post("", { controller: "FilmController", "function": "seen", "film": filmID }, function(page) {
                    $('#rightColumn').load('<?php echo $data['film']->getPath(); ?> #rightColumn');
                } );

                return false;
            });

            $('#unSeeButton').live('click', function(event) {
                event.preventDefault();
                if (confirm("Are you sure you want to un-see <?php echo $data['film']->getTitle(); ?>?")) {
                    var filmID = $(this).parent().find('input[name=film]').val();

                    $.post("", { controller: "FilmController", "function": "unSee", "film": filmID }, function(page) {
                        $('#rightColumn').load('<?php echo $data['film']->getPath(); ?> #rightColumn');
                    } );
                    return false;
                };
            });

            $('.rateStar').live('click', function(event) {
                event.preventDefault();

                var currentRating = <?php echo $data['rating']; ?>;

                var rating  = $(this).find('input[name=rating]').val();

                if (currentRating != 0) {
                    if (!confirm("Are you sure you want to change your rating of <?php echo $data['film']->getTitle(); ?> to " + rating + " stars?")) {
                        return false;
                    }
                }

                $.post("", { controller: "FilmController", "function": "rate", "rating": rating }, function(page) {
                    $('#rightColumn').load('<?php echo $data['film']->getPath(); ?> #rightColumn');
                });
                
                return false;
            });

         });
     </script>
 </body>
 </html>
 
