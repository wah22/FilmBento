<!DOCTYPE html>
 <html lang="en">
 <head>
    <title>FilmBento / <?php echo $data['user']->getHandle(); ?></title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include ("header.php"); ?>
            <div id="userProfile">
                <div id="leftColumn">
                    <div id="info">
                        <img src="<?php echo $data['user']->getAvatar(); ?>">
                        <h1><?php echo $data['user']->getHandle(); ?></h1>
                        <?php if ($data['user']->getAge()) : ?>
                        <?php echo $data['user']->getAge(); ?>
                        <?php endif; ?>
                        <?php if ($data['user']->getSex()) : ?>
                        <?php if ($data['user']->getSex() == 2)echo "Male"; else echo "Female"; ?>
                        <?php endif; ?>
                        <?php if ($data['user']->getLocation()) : ?>
                        <?php echo $data['user']->getLocation(); ?>
                        <?php endif; ?>
                        <?php if ($data['user']->getTwitter()) : ?>
                        <a href="http://twitter.com/#!/<?php echo $data['user']->getTwitter(); ?>">@<?php echo $data['user']->getTwitter(); ?></a>
                        <?php endif; ?>
                        <p><?php echo $data['numSeen']; ?> films seen (<?php echo $data['percentSeen']; ?>% of all)</p>
                        <p>Positivity Rating: <?php echo $data['positivity']; ?>%</p>
                        <div style="clear: both;"></div>
                    </div>

                    <?php if (isset($data['compatibility'])) : ?>
                    <div id="userPanel">
                        <p>Your compatibility with <?php echo $data['user']->gethandle(); ?> is<span style="font-weight:bold; font-size: 20px;"> <?php echo $data['compatibility']; ?>%</span>. <span class="pie"><?php echo $data['compatibility']; ?>/100</span>
                    </div>
                    <?php endif; ?>
                </div>

            <?php if($data['seens']) : ?>
            <div class="list">
                <a href="/<?php echo $data['user']->getHandle(); ?>/films">
                    <h1><?php echo $data['user']->getHandle(); ?> has seen</h1>
                </a>
                <ul>
                    <?php foreach ( $data['seens'] as $seen ) : ?>
                    <li>
                        <!--<img src="<?php //echo $seen['film']->getMeta('poster_link'); ?>">-->
                        <div class="title">
                            <a href='<?php echo $seen['path']; ?>'><?php echo $seen['title']; ?></a>
                        </div>

                        <div class="rating">
                            <?php for ( $i = 0 ; $i < $seen['rating']; $i++ ) : ?>
                            <img src="/images/stars/star_filled.png">
                            <?php endfor; ?>
                        </div>

                        <div class="whenSeen"><?php echo $seen['when']; ?></div>

                        <?php if ($seen['tweeview']) : ?>
                        <div class="tweeview">
                            &ldquo;<?php echo $seen['tweeview']; ?>&rdquo;
                        </div>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="viewMore">
                    <?php if ($data['numSeen'] > 10) : ?>
                    <a href="/<?php echo $data['user']->getHandle(); ?>/films">View More ></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php foreach ($data['lists'] as $list) : ?>
                <?php if (isset($list['films'][0])) : ?>
                    <div class="userList">
                        <h1><?php echo $list['name']; ?><br></h1>
                        <ul>
                            <?php foreach ($list['films'] as $key=>$film) : ?>
                                <li>
                                    <span class="key"><?php echo $key+1; ?></span>
                                    <a href='<?php echo $film['path']; ?>'><?php echo $film['title']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <?php include "footer.php"; ?>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
    <script src="/scripts/jquery.peity.js" type="text/javascript"></script>
    <script src="/scripts/jquery.peity.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('#userProfile li').hover(
            function() {
               $(this).css('background-color', 'white');
            },
            function() {
               $(this).css('background-color', '#F6F5F0');
            });

            $("span.pie").peity("pie", {radius: 30, colours: ['#FFF4DD', '#DF890A']});

        });
    </script>
</body>
</html>
