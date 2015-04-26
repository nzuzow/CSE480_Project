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
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Project Page</title>
    <link href="css/main.css" type="text/css" rel="stylesheet" />
    <!--<link type="text/css" rel="stylesheet" href="css/Squire-UI.css"/>
    -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            var editor;

            $(iframe).load(function() {
               editor = iframe.contentWindow.editor
            });
        });
    </script>
</head>
<body>
<?php echo Format::header($title); ?>

<div class = "main">
    <div class="left">
        <?php echo $projView->displayOwner();?>
        <?php echo $projView->displayAddDoc();?>
    </div>
    <div class="right">
        <?php echo $projView->displayCollaborators();?>
    </div>
</div>
<!--<iframe src="build/document.html"></iframe>
-->
<?php echo Format::footer(); ?>
</body>
</html>