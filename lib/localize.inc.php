<?php
/**
 * Function to localize our site
 * @param $site Site object
 */
return function(Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('elhazzat@cse.msu.edu');
    $site->setRoot('/~madejekz/web/CSE480');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=elhazzat',
        'elhazzat',       // Database user
        'superstudent',     // Database password
        '');            // Table prefix
};