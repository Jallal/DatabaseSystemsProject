<?php
$login = false;
require_once "../lib/site.inc.php";
?>
<?php

unset($_SESSION['lostpassword-error']);



$nu = new Comments($site);



if(isset($_POST['comment'])){
    $users = new Users($site);
    $user= $_SESSION['user'];
    $UID = $user->getUserid();
    $nu->createCommentsForDOC( $UID,strip_tags($_POST['docID']),strip_tags($_POST['comment']));
}


header("location: ../showProject.php?i=".$_POST['projectID']);
exit;