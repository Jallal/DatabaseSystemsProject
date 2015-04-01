<?php
require "../lib/site.inc.php";

unset($_SESSION['edituser-error']);

$users = new Users($site);
$interest = new Interests($site);



$msg = $users->editUser($user,
    strip_tags($_POST['userid']),
    strip_tags($_POST['name']),
    strip_tags($_POST['email']),
    strip_tags($_POST['city']),
    strip_tags($_POST['state']),
    strip_tags($_POST['privacy']),
    strip_tags($_POST['birthyear'])
);


if(isset($_POST['Interest'])&&isset($_POST['Interest2'])){
   $interest->UpdateUserInterest($user,strip_tags($_POST['userid']), strip_tags($_POST['Interest2']));
  $interest->UpdateUserInterest($user,strip_tags($_POST['userid']), strip_tags($_POST['Interest']));
}
if(isset($_POST['Interest2'])){
   $interest->UpdateUserInterest($user,strip_tags($_POST['userid']), strip_tags($_POST['Interest2']));
}
if(isset($_POST['Interest'])){
    $interest->UpdateUserInterest($user,strip_tags($_POST['userid']), strip_tags($_POST['Interest']));
}



if($msg !== null) {
    $_SESSION['edituser-error'] = $msg;
    header("location: ../edituser.php");
    exit;
}

header("location: ../");
exit;