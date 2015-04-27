<?php
//$login = false;
require_once "../lib/site.inc.php";
?>
<?php

unset($_SESSION['lostpassword-error']);



$nu = new  Users($site);



if(isset($_POST['findme'])){
    $users = new Users($site);
    $user= $_SESSION['user'];
    $UID = $user->getId();
    $key = strip_tags($_POST['findme']);
    $string = preg_replace('/\s+/', '',  $key);
  $search = new SearchView($site,$user,$string);
}



header("location: ../searchResulte.php?i=$string");
exit;