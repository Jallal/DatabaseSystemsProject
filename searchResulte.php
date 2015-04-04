<?php
require "lib/site.inc.php";
$view= new SearchView($site,$user,$_REQUEST);
$name = $view->getName();
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?php echo $name; ?>Search Result</title>
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
        <p><?php echo $view->presentSearch();?></p>
    </div>

</div>
<?php echo Format::footer(); ?>

</body>
</html>