<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 4/30/15
 * Time: 10:59 PM
 */
require "../lib/site.inc.php";

if(isset($_POST['text']) && isset($_POST['docID'])) {
    $message = $_POST['text'];
    $docID = $_POST['docID'];
    $userID = $user->getUserID();

    $comment = new Comment($site);

    $createTime = new DateTime();
    $createTime = $createTime->format('Y-m-d H:i:s');

    $insertRet = $comment->addComment($userID, $docID, $message, $createTime);

    if($insertRet == true) {
        //echo "true";
        $html = "<div class='comm_contain'>";
        $html .= "<p class='comm_id'>$userID</p>";
        $html .= "<p class='comm_time'>$createTime</p>";
        $html .= "<hr/>";
        $html .= "<p class='comm_message'>$message</p>";
        $html .= "</div>";

        echo $html;
    }
    else {

    }
}
?>