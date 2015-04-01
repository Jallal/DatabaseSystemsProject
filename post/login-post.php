<?php
$login = true;
require '../lib/site.inc.php';

if(isset($_POST['user']) && isset($_POST['password'])) {
    $users = new Users($site);

    $user = $users->login($_POST['user'], $_POST['password']);
    if(is_a($user, 'User')) {
        $_SESSION['user'] = $user;
        header("location: ../");
        exit;
    }
    else{

        $_POST['error'] = $user;
        //var_dump($_POST['i']);
        //$this->getName()->getID();
        header("location: ../login.php?error=".$_POST['error'].'');
            exit;
    }
}

header("location: ../login.php?error=".$_POST['error'].'');
