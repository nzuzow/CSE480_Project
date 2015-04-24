<?php
$login = false;
require_once "../lib/site.inc.php";
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 4/24/2015
 * Time: 3:48 PM
 */
if(isset($_POST['submit'])) {
  if($_POST['interest']) {
      $interest = $_POST['interest'];
      $uInterests = new UserInterests($site);
      $users = $uInterests->getUsers($interest);
      $test = "<p>" . $users['userID'] . "</p>";
      echo $test;
  }
  else {
      header("location: ../index.php");
      exit;
  }
}

