<?php

require "../lib/site.inc.php";

if(isset($_GET['proj']) && isset($_GET['ownid']) && isset($_GET['i'])) {
    $ownerid = $_GET['ownid'];
    $projid = $_GET['proj'];
    $user = $_GET['i'];
    $invitation = new Invitation($site);
    $invitation->inviteUser($user,$projid,$ownerid);
    $url = $root . "/project.php?proj=" . $projid . "&ownid=" . $ownerid;
    header("location: $url");
    exit;
}