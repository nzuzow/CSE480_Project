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

if(isset($_GET['proj']) && isset($_GET['s']) && isset($_GET['i'])) {
    if($_GET['s'] == a) {
        $projid = $_GET['proj'];
        $user = $_GET['i'];
        $invitation = new Invitation($site);
        $invitation->acceptInvite($user, $projid);
        header("location: $root");
        exit;
    }
    elseif($_GET['s'] == d) {
        $projid = $_GET['proj'];
        $user = $_GET['i'];
        $invitation = new Invitation($site);
        $invitation->removeInvite($user, $projid);
        header("location: $root");
        exit;
    }
}