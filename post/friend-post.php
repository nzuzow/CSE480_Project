<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 3/31/2015
 * Time: 10:31 PM
 */
$login = true;
require '../lib/site.inc.php';

if(isset($_SESSION['user']) && isset($_GET['i'])) {
    $user = $_REQUEST['i'];
    $curr = $_SESSION['user']->getUserID();
    $friendship = new Friendship($site);
    $friendship->requestFriend($curr, $user);
    header("location: ../profile.php?i=" . $user);
    exit;
}