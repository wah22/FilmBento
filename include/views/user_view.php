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
    <div id="pageWrapper">
        <?php include ("header.php"); ?>

        <div id="userProfile">
            <div id="info">
                <img src="<?php echo $data['user']->getGravatar(); ?>">
                <h1><?php echo $data['user']->getHandle(); ?></h1>
                <?php if ($data['user']->getAge()) : ?>
                <p>Age: <?php echo $data['user']->getAge(); ?></p>
                <?php endif; ?>
            </div>

            <div class="list">
                <a href="/?controller=UserController&user=<?php echo $data['user']->getHandle(); ?>&function=films&page=1">
                    <h1><?php echo $data['user']->getHandle(); ?> has seen</h1>
                </a>
                <ul>
                    <?php foreach ( $data['seens'] as $seen ) : ?>
                    <li>
                        <div class="title">
                            <a href='<?php echo $seen['path']; ?>'><?php echo $seen['title']; ?></a>
                        </div>

                        <div class="rating">
                            <?php for ( $i = 0 ; $i < $seen['rating']; $i++ ) : ?>
                            <img src="/images/stars/star_filled.png">
                            <?php endfor; ?>
                        </div>

                        <div class="whenSeen"><?php echo $seen['when']; ?></div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="viewMore">
                    <a href="/?controller=UserController&user=<?php echo $data['user']->getHandle(); ?>&function=films&page=1">View More</a>
                </div>
            </div>


            <?php foreach ($data['lists'] as $list) : ?>
                <?php if (isset($list['films'][0])) : ?>
                    <div class="userList">
                        <h1><?php echo $list['name']; ?><br></h1>
                        <ul>
                            <?php foreach ($list['films'] as $key=>$film) : ?>
                                <li>
                                    <span class="key"><?php echo $key+1; ?></span>
                                    <a href='<?php echo $film['path']; ?>'><?php echo $film['title']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <?php include "footer.php"; ?>
    </div>
</body>
</html>
