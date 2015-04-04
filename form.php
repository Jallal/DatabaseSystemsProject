<?php
require 'lib/site.inc.php';
$view = new UserView($site, $user, $_REQUEST);
?>

<!DOCTYPE html>
<html>
<head>
	<title>New Sight</title>
	<link rel="stylesheet" type="text/css" href="sightings.css" media="screen" />
</head>
<?php echo Format::header($view->getName(),0,0,$view->FriendsCount()); ?>
<body>
<!-- Main body of page -->
<div class="main">
	<!-- Left side items -->
	<div class="left">
	<!-- If you don't put something the column disappears -->
	<p>Enter a new Sight</p>

	</div>

	<!-- Right side items -->
	<div class="right">
		<div class="form">
			<h2>New Sight Form</h2>
			<form action="post/sights-post.php" method="post">
				<p>
					<label for="sightName">Name: </label>
					<input id="sightName" type="text" name="name">
				</p>
				<p>
					<label for="sightDesc">Description: </label>
					<input id="sightDesc" type="text" name="description">
				</p>
				<p><input type="submit"></p>
			</form>
		</div>
	</div>

</div>

<?php echo Format::footer(); ?>

</body>
</html>
