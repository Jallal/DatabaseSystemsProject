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
<head lang="en">
    <meta charset="UTF-8">
    <title>CSE 480 Edit User</title>
    <link href="sightings.css" type="text/css" rel="stylesheet" />
</head>

<!-- Header and navigation -->
<?php echo Format::header($view->getName(),$view->getProjsCount(),$view->getDocsCount(),$view->FriendsCount()); ?>
<body>
<div id="profile">
    <h2>Edit User</h2>
    <form method="post" action="post/edituser-post.php">
        <?php
        if(isset($_SESSION['edituser-error'])) {
            echo "<p>" . $_SESSION['edituser-error'] . "</p>";
            unset($_SESSION['edituser-error']);
        }
        ?>

            <label for="name">Full Name:</label><br>
            <input type="text" id="name" name="name"></p>
        <p>
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email"></p>
        <p>
            <label for="password1">Password:</label><br>
            <input type="password" id="password1" name="password1"></p>
        <p>
            <label for="password2">Password (again):</label><br>
            <input type="password" id="password2" name="password2"></p>
        <p>
            <label for="city">City:</label><br>
            <input type="text" id="city" name="city"></p>
        <p>
            <label for="state">State (Initials):</label><br>
            <input type="text" id="state" name="state"></p>
        <p>
            <label for="privacy">Privacy:</label><br>
            <input type="radio" id="privacy" name="privacy" value="low">Low
            <input type="radio" id="privacy" name="privacy" value="medium">Medium
            <input type="radio" id="privacy" name="privacy" value="high">High</p>
        <p>
        <p>
            <label for="Interest">Interest:</label><br>
            <input type="radio" id="Interest" name="Interest" value="Sport">Sport
            <input type="radio" id="Interest" name="Interest" value="Music">Music
            <input type="radio" id="Interest" name="Interest" value="Tv">Tv</p>
        Other:
        <input type="text" id="Interest2" name="Interest2"></p>
        <p>
            <label for="birthyear">Birth Year:</label><br>
            <input type="text" id="birthyear" name="birthyear"></p>
        <p><input type="submit"></p>
    </form>
</div>
    <?php echo Format::footer(); ?>

</body>
</html>