<?php
/**
 * @file
 * A file loaded for all pages on the site.
 */
require __DIR__ . "/../vendor/autoload.php";
$site = new Sorry\Site();
$localize = require 'localize.inc.php';
if(is_callable($localize)) {
    $localize($site);
}
// Start the session system
session_start();
$user = null;
if(isset($_SESSION[Sorry\User::SESSION_NAME])) {
    $user = $_SESSION[Sorry\User::SESSION_NAME];
}
// redirect if user is not logged in
if((!isset($open) || !$open) && $user === null) {
    $root = $site->getRoot();
    header("location: $root/");
    exit;
}
