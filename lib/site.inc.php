<?php
/**
 * @file
 * @brief A file loaded for all pages on the site.
 */
require __DIR__ . "/autoload.inc.php";

$site = new Site();
$localize = require 'localize.inc.php';
if(is_callable($localize)) {
    $localize($site);
}

// Start the session system
session_start();
$user = null;
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

// redirect if user is not logged in
if(!isset($login) && $user === null) {
    $root = $site->getRoot();
    header("location: $root/login.php");
    exit;
}