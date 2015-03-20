<?php
require '../lib/site.inc.php';

$controller = new SightsController($site, $user, $_REQUEST);
header('Location: ' . $controller->getPage());