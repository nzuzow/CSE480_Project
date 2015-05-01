<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 4/30/2015
 * Time: 8:29 PM
 */

require "../lib/site.inc.php";

if(isset($_GET['docid'])) {
    $docid = $_GET['docid'];
    $document = new Document($site);

    $doc = $document->getDocumentById($docid);
    if($doc) {
        if($doc['creatorID'] == $_SESSION['user']->getUserID()) {
            $document->deleteDoc($docid);
            $url = "../project.php?proj=" . $doc['projID'] . "&ownid=". $doc['projOwnerID'];
            header("location: $url");
            exit;
        }

    }

}
if(isset($_GET['projid'])) {
    $projid = $_GET['projid'];
    $project = new Project($site);

    $proj = $project->getProjectByID($projid);
    if($proj) {
        if($proj['ownerID'] == $_SESSION['user']->getUserID()) {
            $project->deleteProj($projid);
        }

    }

}
header("location: $root");
exit;
