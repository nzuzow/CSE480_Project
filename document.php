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

if(isset($_GET['doc_status']) && $_GET['doc_status'] == "new") {
    // This is a new document
    $doc_status = $_GET['doc_status'];
    $filename = $_GET['doc_title'];
    $proj_owner = $_GET['proj_ownerid'];
    $proj_id = $_GET['proj_id'];
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
<div class = "main">
    <div class="document_contain">
        <textarea id="text_input"></textarea>
        <!--<iframe src="build/document.html"></iframe>-->
    </div>
    <?php echo '<input type="hidden" name="doc_status" id="doc_status" value="'.$doc_status.'"/>';
    echo '<input type="hidden" name="doc_title" id="doc_title" value="'.$filename.'"/>';
    echo '<input type="hidden" name="proj_ownerid" id="proj_ownerid" value="'.$proj_owner.'"/>';
    echo '<input type="hidden" name="proj_id" id="proj_id" value="'.$proj_id.'"/>';
    ?>
</div>
<?php echo Format::footer(); ?>
</body>
</html>