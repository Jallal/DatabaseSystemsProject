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



<?php echo Format::header($view->getName(),$view->getProjsCount(),$view->getDocsCount(),$view->FriendsCount()); ?>

<body>





<!-- Main body of page -->
<div class="main">
	<!-- Left side items -->
	<div class="left">

		<?php echo $view->presentSuper();?>
		<br>
		<?php echo $view->presentCurrentFriends();?>
		<br>
		<?php echo $view->presentPendingRequests();?>
		<br>
		<?php echo $view->presentCurrentProjects();?>
		<br>
		<?php echo $view->presentCurrentDocuments();?>


	</div>


	<!-- Right side items -->
	<div class="right">
</div>

<?php echo Format::footer(); ?>

</body>
</html>
