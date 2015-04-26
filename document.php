<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 4/25/15
 * Time: 6:24 PM
 */
require "lib/site.inc.php";
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
<?php echo Format::header("Document"); ?>
<div class = "main">
    <div class="document_contain">
        <textarea id="text_input"></textarea>
        <!--<iframe src="build/document.html"></iframe>-->
    </div>
</div>
<?php echo Format::footer(); ?>
</body>
</html>