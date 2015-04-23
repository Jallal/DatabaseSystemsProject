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
                        <?php
                        $repeatsName = str_repeat('&nbsp;', 10);
                        $repeatsEmail = str_repeat('&nbsp;', 19);
                        $repeatsCity = str_repeat('&nbsp;', 22);
                        $repeatsState = str_repeat('&nbsp;', 20);
                        $repeatsPrivacy = str_repeat('&nbsp;', 17);
                        $repeatsBirth = str_repeat('&nbsp;', 12);
                        $name = $view->getName();
                        $username = $view->getUsername();
                        $email = $view->getEmail();
                        $city = $view->getCity();
                        $state = $view->getState();
                        $privacy = $view->getPrivacy();
                        $birth = $view->getBirthyear();
                        $interests = $view->presentInterests();
                        if($view->isSameUser() || $view->getPrivacy() === "low") {
                            echo <<< HTML
<li><a href="#">Full Name$repeatsName:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name</a></li>
<br><br>
<li><a href="#">UserName$repeatsName:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$username</a></li>
<br><br>
<li><a href="#">Email$repeatsEmail:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$email</a></li>
<br><br>
<li><a href="#">City$repeatsCity:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$city</a></li>
<br><br>
<li><a href="#">State$repeatsState:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$state</a></li>
<br><br>
<li><a href="#">Privacy$repeatsPrivacy:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$privacy</a></li>
<br><br>
<li><a href="#">Birth Year$repeatsBirth:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$birth</a></li>
<br><br>
<li><a href="#">Your interests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $interests</a></li>
<br><br>
HTML;
                        } else {
                            if ($view->areCollabs() || $view->areFriends()) {
                                echo <<< HTML
<li><a href="#">Full Name$repeatsName:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name</a></li>
<br><br>
<li><a href="#">UserName$repeatsName:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$username</a></li>
<br><br>
<li><a href="#">Email$repeatsEmail:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$email</a></li>
<br><br>
<li><a href="#">City$repeatsCity:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$city</a></li>
<br><br>
<li><a href="#">State$repeatsState:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$state</a></li>
<br><br>
<li><a href="#">Privacy$repeatsPrivacy:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$privacy</a></li>
<br><br>
<li><a href="#">Birth Year$repeatsBirth:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$birth</a></li>
<br><br>
<li><a href="#">Your interests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $interests</a></li>
<br><br>
HTML;
                            } else {
                                echo <<< HTML
<li><a href="#">UserName$repeatsName:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$username</a></li>
<br><br>
<li><a href="#">Your interests&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: $interests</a></li>
<br><br>
HTML;
                            }
                        }
                        ?>

                </ul>
            </div>
        </div>
    <?php echo Format::footer(); ?>
</body>
</html>


