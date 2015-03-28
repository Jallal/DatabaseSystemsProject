<?php
$login = false;
require_once "../lib/site.inc.php";

unset($_SESSION['newuser-error']);

$users = new Users($site);
$msg = $users->newUser(
    strip_tags($_POST['userid']),
    strip_tags($_POST['name']),
    strip_tags($_POST['email']),
    strip_tags($_POST['password1']),
    strip_tags($_POST['password2']),
    strip_tags($_POST['city']),
    strip_tags($_POST['state']),
    strip_tags($_POST['privacy']),
    strip_tags($_POST['birthyear'])
);

if($msg !== null) {
    $_SESSION['newuser-error'] = $msg;
    header("location: ../newuser.php");
    exit;
}

header("location: ../login.php");
exit;