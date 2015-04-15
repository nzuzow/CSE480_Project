<?php
require "lib/site.inc.php";
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
<header><h1>Homepage</h1></header>
<?php echo Format::header($name); ?>
<div class = "main">
	<div class="left">
	<?php echo $view->presentCurrUser(); ?>
	</div>
	<div class="right">
			<?php echo $view->presentUsers(); ?>
			<?php echo $view->presentFriends();?>
			<?php echo $view->presentPending();?>
	</div>
</div>
<?php echo Format::footer(); ?>
</body>
</html>
