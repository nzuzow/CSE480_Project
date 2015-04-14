<?php
require "lib/site.inc.php";

// This if is never getting called because 'r' is not defined
if(isset($_GET['r'])) {
    $users = new Users($site);
    $user = $users->getUser($user->getUserID());
}

$view = new UserView($site, $user, $_REQUEST);
$name = $view->getName();

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $name; ?></title>
    <link href="css/main.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo Format::header($name); ?>
<section>

<div id="userinfo">
    <h2>User Info</h2>
    <?php echo $view->presentProfile(); ?>
</div>
    <?php echo $view->presentUpdate(); ?>
    <?php
    if(isset($_SESSION['update-error'])) {
        echo "<p>" . $_SESSION['update-error'] . "</p>";
        unset($_SESSION['update-error']);
    }
    ?>
    <?php echo $view->getAdd(); ?>

</section>
<?php echo Format::footer(); ?>
</body>
</html>