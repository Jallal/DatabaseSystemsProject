<?php
require "../lib/site.inc.php";

unset($_SESSION['edituser-error']);

$users = new Users($site);
$msg = $users->editUser($user,
    strip_tags($_POST['userid']),
    strip_tags($_POST['name']),
    strip_tags($_POST['email']),
    strip_tags($_POST['city']),
    strip_tags($_POST['state']),
    strip_tags($_POST['privacy']),
    strip_tags($_POST['birthyear'])
);

if($msg !== null) {
    $_SESSION['edituser-error'] = $msg;
    header("location: ../edituser.php");
    exit;
}

header("location: ../");
exit;