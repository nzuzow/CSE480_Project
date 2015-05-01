<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 4/25/15
 * Time: 6:24 PM
 */
require "lib/site.inc.php";
// initialize doc_status to be old, then we will over-write this
// if the user is trying to create a new document.
$doc_status = "old";
$file_contents = "";
$version_num = "";
$p_docid = "";

$doc_view = new DocumentView($site);

$invitation = new Invitation($site);
$loggedUser = $_SESSION['user']->getUserID();
$collabProjs = $invitation->getProjForCollab($loggedUser);
if(!($loggedUser == $_GET['proj_ownerid'])) {
    if(!$collabProjs)
    {
        header("location: $root");
        exit;
    }
    if(!in_array($_GET['proj_id'], $collabProjs)) {
        header("location: $root");
        exit;
    }
}


$fileNameTest = str_replace(" ", "", $_GET['doc_title']);
if(!$fileNameTest)  {
    $url = $root . "/project.php?proj=" . $_GET['proj_id'] . "&ownid=" . $_GET['proj_ownerid'];
    header("location: $url");
    exit;
}



if(isset($_GET['doc_status']) && $_GET['doc_status'] == "new") {
    // This is a new document
    $doc_status = $_GET['doc_status'];
    $filename = $_GET['doc_title'];
    $proj_owner = $_GET['proj_ownerid'];
    $proj_id = $_GET['proj_id'];
}
if(isset($_GET['doc_status']) && $_GET['doc_status'] == "old") {
    // This means we have a document that has already been created.
    // We now need to get the title, the ownerID, the projID, and the
    // parentDocID from the URL.
    $doc_status = $_GET['doc_status'];
    $filename = $_GET['doc_title'];
    $proj_owner = $_GET['proj_ownerid'];
    $proj_id = $_GET['proj_id'];
    $p_docid = $_GET['p_docid'];

    // We also need to load in the contents of the file here.
    // The files are stored with projID_creatorID_versionNo_parentDocID_filename.txt
    // I believe this would be best implemented in the Documents class.
    // The value stored in $p_docid above is really the docID that we want
    // from the Documents database, so we should be able to create a
    // function in the Documents class and just pass it that docid and
    // get everything from the database based on that.
    $doc = new Document($site);
    $doc_row = $doc->getDocumentById($p_docid);

    $creator_id = $doc_row['creatorID'];
    $version_num = $doc_row['versionNo'];
    $old_p_docid = $doc_row['parentDocID'];
    // Replace any spaces with "-" in the filename
    $filename2 = str_replace(" ", "-", $filename);
    $path = "Documents/".$proj_id."_".$creator_id."_".$version_num."_".$old_p_docid."_".$filename2.".txt";

    $file_contents = file_get_contents($path);

    // Initialize curr docid and curr parent docid
    $curr_docid = $p_docid;
    $curr_parent_docid = $old_p_docid;
    $curr_vnum = $version_num;

    $doc_tree = $doc_view->getDocumentTree($curr_docid, $curr_parent_docid, $curr_vnum, $filename);
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Document Page</title>
    <link href="css/main.css" type="text/css" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="css/Squire-UI.css"/>
    <!---->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="build/squire.js"></script>
    <script type="text/javascript" src="build/Squire-UI.js"></script>
    <script>
        $(document).ready(function() {
            new SquireUI({replace: 'textarea#text_input', height: 550});
        });
    </script>
</head>
<body>
<?php echo Format::header($filename); ?>
<div id="doc_main" class = "main">
    <div class="left_sidebar">
        <?php
        if($doc_status == "old") {
        echo $doc_tree;
        }

        echo $doc_view->displayAddComment();
        ?>
    </div>

    <div class="document_contain">
        <textarea id="text_input"></textarea>
        <!--<iframe src="build/document.html"></iframe>-->
    </div>
    <?php echo '<input type="hidden" name="doc_status" id="doc_status" value="'.$doc_status.'"/>';
    echo '<input type="hidden" name="doc_title" id="doc_title" value="'.$filename.'"/>';
    echo '<input type="hidden" name="proj_ownerid" id="proj_ownerid" value="'.$proj_owner.'"/>';
    echo '<input type="hidden" name="proj_id" id="proj_id" value="'.$proj_id.'"/>';
    echo '<input type="hidden" name="old_contents" id="old_contents" value="'.$file_contents.'"/>';
    echo '<input type="hidden" name="old_version" id="old_version" value="'.$version_num.'"/>';
    echo '<input type="hidden" name="p_docid" id="p_docid" value="'.$p_docid.'"/>';
    ?>
</div>
<?php echo Format::footer(); ?>
</body>
</html>