<?php
require "lib/site.inc.php";
$view = new UserView($site, $user, $_REQUEST);
$name = $view->getName();
if(isset($_SESSION['userIDs'])) {
    $userIDs = $_SESSION['userIDs'];
    $sView = new SearchView($site, $userIDs);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $name; ?></title>
    <link href="css/main.css" type="text/css" rel="stylesheet" />
</head>
<body>
<header><h1>Homepage</h1></header>
<?php echo Format::header($name); ?>
<div class = "main">
    <div class="left">
    </div>
    <div class="right">
        <?php echo $sView->presentUsers(); ?>
    </div>
</div>
<?php echo Format::footer(); ?>
</body>
</html>