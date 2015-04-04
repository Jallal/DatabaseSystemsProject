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
    public static function header($title,$DocCount,$FileCount,$FriendsCount)
    {
        return <<<HTML
<!-- Header and navigation -->
<header>
	<h1>
		<img src="images/right-eye.jpg" width="140" height="70" alt="Eye"> $title
	      </h1>
	<div class="farright">
	<div id="content" class="clearfix">
		<div id="userStats" class="clearfix">
			<div class="data">
				<div class="sep"></div>
				<ul class="numbers clearfix">
					<li>Projects<strong>$DocCount</strong></li>
					<li>Documents<strong>$FileCount</strong></li>
					<li class="nobrdr">Friends<strong>$FriendsCount</strong></li>
				</ul>
			</div>
		</div>
	</div>
</div>

</header>
<div id="list1">
<nav>
	<ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="#">New Project</a></li>
		<li><a href="post/logout-post.php">Logout</a></li>
	<li><form name="search" action="post/search-post.php" method="post">
		<input class = "search" type="text"  name="title"  value=" ">
		<input class = "search" type="submit"  name ="search"   value="Search">
	</form>
	</li>

	</ul>
</nav>
</div>
HTML;
    }

    /**
     * Generate HTML for the standard page footer
     * @return string html
     */
    public static function footer() {
        return <<<HTML
<footer>
	<p>Copyright 2015, Sharing made Simple, Inc.</p>
</footer>
HTML;

    }
}