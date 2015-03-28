<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>CSE 480 Login</title>
    <link href="css/main.css" type="text/css" rel="stylesheet" />
</head>
<body>
<!-- Header and navigation -->
<header><h1>CSE 480 Project</h1></header>

<div id="login">
<h2>Login</h2>
<form method="post" action="post/login-post.php">
    <p>
        <label for="user">User name or Email:</label><br>
        <input type="text" id="user" name="user"></p>
    <p><label for="password">Password:</label><br>
        <input type="password" id="password" name="password">
    </p>
    <p><input type="submit"></p>
    <p class="login-options">-OR-</p>
    <p class="login-options"><a href="lostpw.php">Lost Password</a></p>
    <p class="login-options"><a href="newuser.php">New User</a></p>
    <?php
    if(isset($_SESSION['login-error'])) {
        echo "<p>" . $_SESSION['login-error'] . "</p>";
        unset($_SESSION['login-error']);
    }
    ?>
</form>
</div>
</body>
</html>
