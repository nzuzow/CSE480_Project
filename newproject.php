<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 4/24/15
 * Time: 5:48 PM
 */
$login = false;
require_once "lib/site.inc.php";
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>New Project</title>
    <link href="css/main.css" type="text/css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // setTimeout() function will be fired after page is loaded
            // it will wait for 5 sec. and then will fire
            // $(".newproj_error").hide() function
            setTimeout(function() {
                $(".newproj_error").hide(500)
            }, 5000);
        });
    </script>
</head>
<body>
<!-- Header and navigation -->
<header><h1>New Project</h1></header>

<div id="new_project">
    <?php
    if(isset($_SESSION['newproj-error'])) {
        echo $_SESSION['newproj-error'];
        unset($_SESSION['newproj-error']);
    }
    ?>
    <h2>New Project</h2>
    <p id="new_desc">Enter the desired name of your new project below, then click the Create button.</p>
    <form method="post" action="post/newproj-post.php">
        <p>
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name">
        </p>
        <p><input type="submit" value="Create"></p>
    </form>
    <?php
    $link = "<a href='".$root."'>Back to Home Page</a>";
    echo $link;
    ?>
</div>
</body>
</html>