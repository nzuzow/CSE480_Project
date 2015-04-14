<?php

/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('zuzownic@cse.msu.edu');
    $site->setRoot('/~zuzownic/CSE480');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=zuzownic',
        'zuzownic',       // Database user
        'A44122780',     // Database password
        '480_');            // Table prefix
};

?>
