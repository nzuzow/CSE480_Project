<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 4/24/15
 * Time: 5:50 PM
 */
$login = false;
require_once "../lib/site.inc.php";

unset($_SESSION['newproj-error']);
unset($_SESSION['newproj-success']);

$np = new Project($site);
if(isset($_POST['name']))
{
    $curr_userid = $user->getUserID();
    $title = strip_tags($_POST['name']);

    // make sure the title isn't empty
    if($title == '' || $title == ' ') {
        $_SESSION['newproj-error'] = "<p class='newproj_error'>A name is required for the project</p>";
        header("Location: $root/newproject.php");
        exit;
    }

    //echo "The user id is: ".$curr_userid." and The title is: ".$title."<br/>";
    $addedProject = $np->addProject($curr_userid, $title);

    if($addedProject === false) {
        $_SESSION['newproj-error'] = "<p class='newproj_error'>An error occurred while trying to add the project. Please try again</p>";
        header("Location: $root/newproject.php");
        exit;
    }

    $_SESSION['newproj-success'] = "<p class='newproj_success'>The project ".$title." was added successfully.</p>";
    header("Location: $root");
    exit;
}
?>