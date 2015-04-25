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
</head>
<body>
<?php echo Format::header($title); ?>

<div class = "main">
    <div class="left">
        <?php echo $projView->displayOwner();?>
    </div>
    <div class="right">
        <?php echo $projView->displayCollaborators();?>
    </div>
</div>

<?php echo Format::footer(); ?>
</body>
</html>