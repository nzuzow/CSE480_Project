<?php
$login = true;
require '../lib/site.inc.php';

unset($_SESSION['login-error']);

if(isset($_POST['user']) && isset($_POST['password'])) {
    $users = new Users($site);

    $user = $users->login($_POST['user'], $_POST['password']);
    if($user !== null) {
        $_SESSION['user'] = $user;
        header("location: ../");
        exit;
    }
}
$_SESSION['login-error'] = "Invalid username and/or password.";
header("location: ../login.php");
exit;