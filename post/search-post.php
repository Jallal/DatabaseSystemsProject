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
   $search = new SearchView($site,$user,$_POST['title']);
}




header("location: ../searchResulte.php?i=".$_POST['title'].'');
exit;