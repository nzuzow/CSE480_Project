<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 4/26/15
 * Time: 1:52 AM
 */
$login = false;
require_once "../lib/site.inc.php";

$doc = new Document($site);
if(isset($_POST['content']) && isset($_POST['status']) && isset($_POST['title']) && isset($_POST['proj_ownerid']) && isset($_POST['proj_id']))
{
    // All three of these should be set when the user clicks the save
    // button on the document.php page.
    /*$response = "The content is: ".$_POST['content']."<br/>";
    $response .= "The status is: ".$_POST['status']."<br/>";
    $response .= "The title is: ".$_POST['title']."<br/>";
    $response .= "The owner id is: ".$_POST['proj_ownerid']."<br/>";
    $response .= "The project id is: ".$_POST['proj_id']."<br/>";
    //echo $response;
    */
    //return $response;

    $content = $_POST['content'];
    $projID = $_POST['proj_id'];
    $projOwnerID = $_POST['proj_ownerid'];
    $creatorID = $user->getUserID();
    $fileName = $_POST['title'];
    $status = $_POST['status'];
    $old_version = $_POST['old_version'];
    $p_docid = $_POST['p_docid'];

    if($status == "new") {
        $versionNo = "1";
        // If this is a new document. Set the parentDocID equal to NULL.
        $parentDocID = NULL;
    }
    else {
        // Need to get the current version number
        // and increment it by 1. Also we need to get the
        // document ID of the parent document.
        if($old_version != "") {
            $versionNo = $old_version + 1;
        }

        if($p_docid != "") {
            $parentDocID = $p_docid;
        }
    }

    $createTime = new DateTime();
    $createTime = $createTime->format('Y-m-d H:i:s');

    $doc_resp = $doc->addDocument($projID, $projOwnerID, $creatorID, $fileName, $versionNo, $createTime, $parentDocID);

    if($doc_resp == true)
    {
        // Make sure the filename is one word by replacing the spaces with
        // dashes.
        $fileName2 = str_replace(" ", "-", $fileName);

        // The project was added to the database. Now we need to
        // save the file in the Documents folder on the server.
        $path = "../Documents/".$projID."_".$creatorID."_".$versionNo."_".$parentDocID."_".$fileName2.".txt";

        // Write the contents back to the file
        file_put_contents($path, $content);
        chmod($path, 0777);
    }
    if($doc_resp == false)
    {
        // There was an error.
        return false;
    }

    $return[] = "The document ".$fileName." was added successfully";
    $return[] = "proj=".$projID."&ownid=".$projOwnerID;
    echo $return[0].";".$return[1];

}
?>