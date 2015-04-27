<?php
require 'lib/site.inc.php';
$view = new DocView($site, $user, $_REQUEST);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $view->getuserName(); ?></title>
    <link rel="stylesheet" type="text/css" href="sightings.css" media="screen" />
</head>



<?php echo Format::header($view->getuserName(),$view->getProjsCount(),$view->getDocsCount(),$view->FriendsCount()); ?>

<body>





<!-- Main body of page -->
<div class="main">
    <!-- Left side items -->
    <div class="left">
        <p></p>
    </div>

    <!-- Right side items -->
    <div class="right">
        <h1><?php echo $view->getDocName(); ?></h1>
        <?php echo $view->showDocTree(); ?>
    </div>

    <?php echo Format::footer(); ?>

</body>
</html>
