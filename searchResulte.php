<?php
require "lib/site.inc.php";
$view= new SearchView($site,$user,$_REQUEST);
$name = $view->getName();
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?php echo $name; ?> Sightings Activity</title>
    <link rel="stylesheet" type="text/css" href="sightings.css" media="screen" />
</head>
<body>
<?php echo Format::header("$name Sightings"); ?>
<!-- Main body of page -->
<div class="main">
    <!-- Left side items -->
    <div class="left">



        <div class="options">
            <h2>FRIENDS</h2>
            <p><a href="#">Anton Phibes</a></p>
            <p><a href="#">Jennifer</a></p>
        </div>

    </div>

    <!-- Right side items -->
    <div class="right">
        <p><?php echo $view->presentSearch();?></p>
    </div>

</div>
<?php echo Format::footer(); ?>

</body>
</html>