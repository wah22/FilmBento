<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmBento / Account Settings</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type ="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/humanity/jquery-ui.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include ROOT_PATH . '/include/views/header.php'; ?>
        <h1>Manage My Account</h1>
        <?php if (!empty($data['errors'])) : ?>
        <div id="errors">
            <?php foreach ($data['errors'] as $error) : ?>
            <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div id="accountSettings">
            <form method="post" action="/?controller=AccountSettingsController&function=save">
                <fieldset>
                    <legend>My Credentials</legend>
                        <label for="email">Email</label>
                        <input type="email" value="<?php echo $data['user']->getEmail(); ?>" name="email">
                        <label for="email">Password</label>
                        <input type="password" name="password">
                    <input type="submit" value="Save">
                </fieldset>
            </form>
            <form method="post" action="/?controller=AccountSettingsController&function=save">
                <fieldset>
                    <legend>My Details</legend>
                    <label for="dob">Date of Birth</label>
                    <input type="text" name="dob" id="dob" value="<?php if ($data['user']->getDOB()) { echo date('m/d/Y', $data['user']->getDOB());} ?>">
                    <input type="submit" value="Save">
                </fieldset>
            </form>
            <form>
                <fieldset>
                    <legend>My Avatar</legend>
                    <p>FilmBento uses <a href="http://en.gravatar.com/">Gravatar</a> for avatars.</p>
                    <p>You can set or change your avatar there.</p>
                    <div class="notes">
                        <p>Currently using <?php echo $data['user']->getEmail(); ?></p>
                    </div>
                </fieldset>
            </form>
            <form method="post" action="">
                <fieldset>
                    <legend>Delete my Account</legend>
                    <p>Wanna get rid of your FilmBento page?</p>
                    <p>You'll lose everything.</p>
                    <input type="hidden" name="controller" value="AccountSettingsController">
                    <input type="hidden" name="function" value="deleteAccount">
                    <button id="submit" class="button negative"><span class="cross icon"></span>Delete Account</button>
                </fieldset>
            </form>
        </div>
        <?php include ROOT_PATH . '/include/views/footer.php'; ?>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
    <script>
        $(function() {
		$("#dob").datepicker({ changeMonth: true, changeYear: true, yearRange: '1900:+0' });
	});
    </script>
</body>
</html>
