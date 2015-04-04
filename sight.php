<?php
require 'lib/site.inc.php';
$view = new SightView($site, $_REQUEST, $user);
if($view->shouldRedirect()) {
    $root = $site->getRoot();
    header("location: $root");
    exit;
}
$name = $view->getName();
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?php echo $name; ?> Home Page</title>
    <link href="sightings.css" type="text/css" rel="stylesheet" />
</head>


<?php echo Format::header($view->getName(),0,0,$view->FriendsCount()); ?>
<body>
<!-- Main body of page -->
<div class="main">
    <!-- Left side items -->
    <div class="left">

        <div class="options">
            <h2>STATS</h2>
            <p>23 Followers</p>
            <p>18 Sightings</p>
        </div>

    </div>

    <!-- Right side items -->
    <div class="right">
        <div class="description">
        </div>

        <div class="sighting">

        </div>

        <div class="sighting">

        </div>

    </div>

</div>

<?php echo Format::footer(); ?>

</body>
</html>