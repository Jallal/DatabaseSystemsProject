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
        <br>
        <div class="sighting">
            <h3>Update Document</h3>
            <form method="post" action="doc-post.php" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="16000000">
                <input type="hidden" name="projid" value="<?php echo $view->getProjid(); ?>">
                <input type="hidden" name="userid" value="<?php echo $view->getUserid(); ?>">
                <input name="document" type="file" id="document">
                <input name="upload" type="submit" id="upload" value="Upload">
            </form>
        </div>
        <br>
        <h3>Document Tree:</h3>
        <?php echo $view->showDocTree(); ?>
    </div>

    <?php echo Format::footer(); ?>

</body>
</html>
