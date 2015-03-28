<?php
$login = false;
require_once "lib/site.inc.php";
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>New User</title>
    <link href="css/main.css" type="text/css" rel="stylesheet" />
</head>
<body>
<!-- Header and navigation -->
<header><h1>New User</h1></header>

<div id="login">
    <h2>New User</h2>
    <form method="post" action="post/newuser-post.php">
        <p>
            <label for="userid">User ID:</label><br>
            <input type="text" id="userid" name="userid">
        </p>
        <p>
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name">
        </p>
        <p>
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email">
        </p>
        <p>
            <label for="password1">Password:</label><br>
            <input type="password" id="password1" name="password1">
        </p>
        <p>
            <label for="password2">Password (again):</label><br>
            <input type="password" id="password2" name="password2">
        </p>
        <p>
            <label for="secret">Secret:</label><br>
            <input type="password" id="secret" name="secret">
        </p>
        <p><input type="submit"></p>
        <?php
        if(isset($_SESSION['newuser-error'])) {
            echo "<p>" . $_SESSION['newuser-error'] . "</p>";
            unset($_SESSION['newuser-error']);
        }
        ?>
    </form>
    <a href="login.php">Back to Login Page</a>
</div>
</body>
</html>