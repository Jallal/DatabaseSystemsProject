<?php
require '../lib/site.inc.php';
unset($_SESSION['user']);
header("location: ../login.php");