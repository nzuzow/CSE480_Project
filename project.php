<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 4/25/15
 * Time: 2:53 AM
 */
require "lib/site.inc.php";

if(isset($_GET['proj']) && isset($_GET['ownid'])) {
    $ownerid = $_GET['ownid'];
    $projid = $_GET['proj'];
}
$projView = new ProjectView($site, $ownerid, $projid);
$title = $projView->getTitle();

$invitation = new Invitation($site);
$loggedUser = $_SESSION['user']->getUserID();
$collabProjs = $invitation->getProjForCollab($loggedUser);
    if (!($loggedUser == $ownerid)) {
        if(!$collabProjs)
        {
            header("location: $root");
            exit;
        }
        elseif (!in_array($projid, $collabProjs)) {
            header("location: $root");
            exit;
        }
}

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Project Page</title>
    <link href="css/main.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo Format::header($title); ?>

<div class = "main">
    <div class="left">
        <?php echo $projView->displayOwner();?>
        <?php echo $projView->displayAddDoc();?>
    </div>
    <div class="right">
        <?php echo $projView->displayDocuments();?>
        <?php echo $projView->displayCollaborators();?>
        <?php
        if($ownerid == $user->getUserID()) {
            echo $projView->displayNonCollabs();
        }
        ?>
    </div>
</div>
<?php echo Format::footer(); ?>
</body>
</html>