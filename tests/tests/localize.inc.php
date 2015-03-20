<?php
/**
 * Function to localize our site
 * @param $site Site object
 */
return function(Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('madejekz@cse.msu.edu');
    $site->setRoot('/~madejekz/step5');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=madejekz',
        'madejekz',       // Database user
        'Tomizzo15',     // Database password
        'test_');            // Table prefix
};