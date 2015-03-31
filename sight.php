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
    <title><?php echo $name; ?> Sightings</title>
    <link href="sightings.css" type="text/css" rel="stylesheet" />
</head>
<body>

<?php echo Format::header("$name Sightings"); ?>

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
            <p><?php echo $view->getDescription(); ?></p>
        </div>

        <div class="sighting">
            <h2><a href="#">Tom Izzo</a></h2>
            <p class="time">1-15-2015 6:45pm</p>
            <p>Tom was getting ready for his radio show and shooting the breeze with some other
                patrons at the bar.</p>
            <p class="awesome"><a href="#"><img src="images/awesome.jpg" width="" height="15" alt="Awesome"></a> 12</p>
            <div class="comments">
                <p><strong><a href="#">Anton Phibes</a></strong> I saw him, too!</p>
                <p><strong><a href="#">Clive Butler</a></strong> Me, too!</p>
            </div>
        </div>

        <div class="sighting">
            <h2><a href="#">Tom Izzo</a></h2>
            <p class="time">1-12-2015 11:45pm</p>
            <p>Leaving the Breslin center in his car.</p>
            <p class="awesome"><a href="#"><img src="images/awesome.jpg" width="" height="15" alt="Awesome"></a> 6</p>
        </div>

    </div>

</div>

<?php echo Format::footer(); ?>

</body>
</html>