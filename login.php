<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Sightings Login</title>
    <link href="sightings.css" type="text/css" rel="stylesheet" />
</head>
<body>
<!-- Header and navigation -->
<header><h1><img src="images/right-eye.jpg" width="102" height="45" alt="Eye"> Sightings</h1></header>

<div id="login">
<h2>Login</h2>
<form method="post" action="post/login-post.php">
    <p>
        <label for="user">User name:</label><br>
        <input type="text" id="user" name="user"></p>
    <p><label for="password">Password:</label><br>
        <input type="password" id="password" name="password">
    </p>
    <p><input type="submit"></p>
</form>
<p><a href="newuser.php">New User</a></p>
</div>
</body>
</html>