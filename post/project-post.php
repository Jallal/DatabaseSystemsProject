<?php
//$login = false;
require_once "../lib/site.inc.php";
?>
<?php

unset($_SESSION['lostpassword-error']);



$nu = new  Users($site);



if(isset($_POST['title'])){

    $users = new Users($site);
    $user= $_SESSION['user'];
    $UID = $user->getId();
    $controller = new SightsController($site,$user,$_POST['title']);
}

if(isset($_REQUEST['delete'])){
    $users = new Users($site);
    $user= $_SESSION['user'];
    $UID = $user->getId();
    $controller = new SightsController($site,$user,$_REQUEST['delete']);
}




header('Location: ' . $controller->getPage());
exit;