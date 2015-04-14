<?php
$login = false;
require_once "../lib/site.inc.php";

unset($_SESSION['update-error']);

$userin = $_SESSION['user'];
$nu = new Users($site);
$msg = $nu->updateUser(
    $userin->getUserID(),
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
    $_SESSION['update-error'] = $msg;
}

header("location: ../profile.php?r=1");
exit;