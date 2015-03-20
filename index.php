<?php
require 'lib/site.inc.php';
$view = new UserView($site, $user, $_REQUEST);
if ($view->shouldRedirect()) {
	$root = $site->getRoot();
	header("location: $root");
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $view->getName(); ?></title>
	<link rel="stylesheet" type="text/css" href="sightings.css" media="screen" />
</head>
<body>

<?php echo Format::header($view->getName()); ?>

<!-- Main body of page -->
<div class="main">
	<!-- Left side items -->
	<div class="left">
		<?php echo $view->presentSights(); ?>

		<div class="options">
		<h2>FOLLOWING</h2>
		<p><a href="#">Vincent Price</a></p>
		<p><a href="#">The Team Bus</a></p>
		</div>

		<div class="options">
		<h2>FRIENDS</h2>
		<p><a href="#">Anton Phibes</a></p>
		<p><a href="#">Jennifer</a></p>
		</div>

	</div>

	<!-- Right side items -->
	<div class="right">
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
			<h2><a href="#">Sparty</a></h2>
			<p class="time">1-16-2015 8:45pm</p>
			<p>At the game, dude, at the game!</p>
			<p class="awesome"><a href="#"><img src="images/awesome.jpg" width="" height="15" alt="Awesome"></a> 3</p>
		</div>
	</div>

</div>

<?php echo Format::footer(); ?>

</body>
</html>
