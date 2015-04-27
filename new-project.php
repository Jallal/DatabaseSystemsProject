<?php
require 'lib/site.inc.php';
$view = new UserView($site, $user, $_REQUEST);
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Project</title>
    <link rel="stylesheet" type="text/css" href="sightings.css" media="screen" />
</head>
<?php echo Format::header($view->getName(),0,0,$view->FriendsCount()); ?>
<body>
<!-- Main body of page -->
<div class="main">
    <!-- Left side items -->
    <div class="left">
        <!-- If you don't put something the column disappears -->
        <p></p>

    </div>

    <!-- Right side items -->
    <div class="right">
        <div class="form">
            <h2>New Project Form</h2>
            <form action="post/project-post.php" method="post">
                <p>
                    <label for="sightName">Project Title: </label>
                    <input id="sightName" type="text" name="title">
                </p>
                <p><input type="submit"></p>
            </form>
        </div>
    </div>

</div>

<?php echo Format::footer(); ?>

</body>
</html>
