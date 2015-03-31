<?php
/**
 * Created by PhpStorm.
 * User: Zachary
 * Date: 3/15/2015
 * Time: 1:47 PM
 */

class Format {
    /**
     * Generate HTML for the standard page header
     * @param $title string title
     * @return string html
     */
    public static function header($title)
    {
        return <<<HTML
<!-- Header and navigation -->
<header>
	<h1>
		<img src="images/right-eye.jpg" width="102" height="45" alt="Eye"> $title
	</h1>
</header>
<nav>
	<ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="post/logout-post.php">Log out</a></li>
	<li><form name="search" action="post/search-post.php" method="post">
		<input class = "search" type="text"  name="title"  value=" ">
		<input class = "search" type="submit"  name ="search"   value="Search">
	</form></li>
	</ul>
</nav>
HTML;
    }

    /**
     * Generate HTML for the standard page footer
     * @return string html
     */
    public static function footer() {
        return <<<HTML
<footer>
	<p>Copyright 2015, Super Sightings, Inc.</p>
</footer>
HTML;

    }
}