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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			// setTimeout() function will be fired after page is loaded
			// it will wait for 5 sec. and then will fire
			// $(".newproj_success").hide() function
			setTimeout(function() {
				$(".newproj_success").hide(500)
			}, 5000);
		});
	</script>
</head>
<body>
<header><h1>Homepage</h1></header>
<?php echo Format::header($name); ?>
<div class = "main">
	<?php
	if(isset($_SESSION['newproj-success'])) {
		echo $_SESSION['newproj-success'];
		unset($_SESSION['newproj-success']);
	}
	?>
	<div class="left">
	<?php echo $view->presentCurrUser(); ?>
	<?php echo $view->presentFriends();?>
	</div>
	<div class="right">
			<?php echo $view->presentUsers(); ?>
			<?php //echo $view->presentFriends();?>
			<?php echo $view->presentProjects();?>
			<?php echo $view->presentPending();?>
			<?php echo $view->presentInvites();?>
			<?php echo $view->presentRejected();?>
	</div>
</div>
<?php echo Format::footer(); ?>
</body>
</html>
