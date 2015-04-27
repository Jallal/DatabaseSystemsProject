<?php
//$login = false;
require_once "../lib/site.inc.php";
?>
<?php


var_dump($_POST['invite']);
var_dump($_POST['projectID']);
$this->user->getID()->getName()->getB();

unset($_SESSION['lostpassword-error']);



$nu = new  Users($site);



if(isset($_POST['findme'])){
    $users = new Users($site);
    $user= $_SESSION['user'];
    $UID = $user->getId();
    $key = strip_tags($_POST['findme']);
    $string = preg_replace('/\s+/', '',  $key);
  $search = new SearchView($site,$user,$string);
    header("location: ../searchResulte.php?i=$string");
}

if(isset($_POST['invite'])&&isset($_POST['projectID'])){
    $users = new Users($site);
    $user= $_SESSION['user'];
    $UID = $user->getId();
    $key = strip_tags($_POST['invite']);
    $projID = strip_tags($_POST['projectID']);
    $proid = preg_replace('/\s+/', '',   $projID);
    $string = preg_replace('/\s+/', '',  $key);
    $search = new InviteToProject($site,$user,$string&$proid);
    header("location: ../inviteResults.php?invite=$string&?projectID=$$proid");

}



header("location: ../");
exit;