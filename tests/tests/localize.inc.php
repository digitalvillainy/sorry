<?php
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Sorry\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('walshb15@cse.msu.edu');
    $site->setRoot('/~walshb15/step8');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=walshb15',
        'walshb15',       // Database user
        'Parmeshaun20XX',     // Database password
        'testp2_');            // Table prefix
};