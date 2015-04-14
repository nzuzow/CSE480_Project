<?php
$login = false;
require_once "../lib/site.inc.php";

unset($_SESSION['newuser-error']);

$nu = new Users($site);
$msg = $nu->newUser(
    strip_tags($_POST['userid']),
    strip_tags($_POST['name']),
    strip_tags($_POST['email']),
    strip_tags($_POST['password1']),
    strip_tags($_POST['password2']),
    strip_tags($_POST['city']),
    strip_tags($_POST['state']),
    strip_tags($_POST['privacy']),
    strip_tags($_POST['birthyear']),
    strip_tags($_POST['interests']),
    $site);

if($msg !== null) {
    $_SESSION['newuser-error'] = $msg;
    header("location: ../newuser.php");
    exit;
}

header("location: ../index.php");
exit;