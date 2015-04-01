<?php
require 'lib/site.inc.php';
$view = new UserView($site, $user, $_REQUEST);
if ($view->shouldRedirect()) {
    $root = $site->getRoot();
    header("location: $root");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>CSE 480 Edit User</title>
    <link href="sightings.css" type="text/css" rel="stylesheet" />
</head>
<body>
<!-- Header and navigation -->
<header><h1><img src="images/right-eye.jpg" width="102" height="45" alt="Eye"> Sightings</h1></header>

<div id="profile">
    <h2>Profile</h2>
    <br><br><br>
        <label for="name">Full Name <?php echo str_repeat('&nbsp;', 10);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo  $view->getName();?><br><br>
        <p>
            <label for="email">Email<?php echo str_repeat('&nbsp;', 19);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo $view->getEmail();?><br><br>
        </p>

        <p>
            <label for="city">City<?php echo str_repeat('&nbsp;', 22);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo $view->getCity();?><br><br>
        </p>

        <p>
            <label for="state">State<?php echo str_repeat('&nbsp;', 22);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo $view->getState();?><br><br>
        </p>

        <p>
            <label for="privacy">Privacy<?php echo str_repeat('&nbsp;', 18);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo $view->getPrivacy();?><br><br>
        </p>

    <p>
        <label for="birthyear">Birth Year<?php echo str_repeat('&nbsp;', 14);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo $view->getBirthyear();?><br><br>
    </p>

        <p>
            <label for="Interest">Your interests<?php echo str_repeat('&nbsp;', 10);?>: </label><?php echo $view->presentInterests();?><br><br>

        </p>



    <a href="./">Back to home page</a>
</div>
</body>
</html>