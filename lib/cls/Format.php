<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 3/28/2015
 * Time: 3:08 PM
 */

class Format {

    /**
     * Generate HTML for the standard page header
     * @param $title The page title
     */
    public static function header($title)
    {
        return <<<HTML

<!-- Header and navigation -->
<header><h1>$title</h1></header>
<nav>
	<ul>
		<li><a href="./">Home</a></li>
		<li><a href="profile.php">My Profile</a></li>
		<li><a href="post/logout-post.php">Log out</a></li>
	<li><form>
		<input type="search"> <input type="submit" value="Search">
	</form></li>
	</ul>
</nav>
HTML;
    }
    /**
     * Generate HTML for the standard page footer
     * @param $title The page title
     */
    public static function footer()
    {
        return <<<HTML
<footer>
<p>Copyright 2015, Super Sightings, Inc.</p>
</footer>
HTML;
    }
}