<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 3/31/2015
 * Time: 10:31 PM
 */
$login = true;
require '../lib/site.inc.php';
$root = $site->getRoot();

if(isset($_SESSION['user']) && isset($_GET['i'])) {
    $user = $_REQUEST['i'];
    $curr = $_SESSION['user']->getUserID();
    $friendship = new Friendship($site);
    $friendship->requestFriend($curr, $user);
    header("location: ../profile.php?i=" . $user);
    exit;
}

if(isset($_SESSION['user']) && isset($_GET['a'])) {
    $user = $_GET['a'];
    $curr = $_SESSION['user']->getUserID();
    $friendship = new Friendship($site);
    $friendship->acceptFriend($curr, $user);
    header("location: $root/");
    exit;
}

if(isset($_SESSION['user']) && isset($_GET['d'])) {
    $user = $_GET['d'];
    $curr = $_SESSION['user']->getUserID();
    $friendship = new Friendship($site);
    $friendship->declineFriend($curr, $user);
    header("location: $root/");
    exit;
}