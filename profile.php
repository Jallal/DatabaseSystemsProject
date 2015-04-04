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
<head>
    <title><?php echo $view->getName(); ?></title>
    <link rel="stylesheet" type="text/css" href="sightings.css" media="screen" />
</head>



<?php echo Format::header($view->getName(),$view->getProjsCount(),$view->getDocsCount(),$view->FriendsCount()); ?>

<body>
        <div id="profile">
            <br><br><br>
            <div id="list8">
                <ul>
                    <li><h2><a href="#"><?php echo str_repeat('&nbsp;', 18);?>Profile</h2></a></li>
                    <br><br><br>
                    <li><a href="#">Full Name<?php echo str_repeat('&nbsp;', 10);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo  $view->getName();?></a></li>
                    <br><br>
                    <li><a href="#">Email<?php echo str_repeat('&nbsp;', 19);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo $view->getEmail();?></a></li>
                    <br><br>
                    <li><a href="#">City<?php echo str_repeat('&nbsp;', 22);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo $view->getCity();?></a></li>
                    <br><br>
                    <li><a href="#">State<?php echo str_repeat('&nbsp;', 20);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo $view->getState();?></a></li>
                    <br><br>
                    <li><a href="#">Privacy<?php echo str_repeat('&nbsp;', 17);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo $view->getPrivacy();?></a></li>
                    <br><br>
                    <li><a href="#">Birth Year<?php echo str_repeat('&nbsp;', 12);?>:<?php echo str_repeat('&nbsp;', 5);?></label><?php echo $view->getBirthyear();?></a></li>
                    <br><br>
                    <li><a href="#">Your interests<?php echo str_repeat('&nbsp;', 5);?>: </label><?php echo $view->presentInterests();?></a></li>
                    <br><br>
                </ul>
            </div>
        </div>
    <?php echo Format::footer(); ?>
</body>
</html>


