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
      $userIDs = $uInterests->getUsers($interest);
      if($userIDs !== null) {
          $_SESSION['userIDs'] = $userIDs;
      }
      header("location: ../search.php");
      exit;
  }
  else {
      header("location: ../index.php");
      exit;
  }
}

