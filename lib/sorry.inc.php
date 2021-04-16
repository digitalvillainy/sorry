<?php
require __DIR__ . "/../vendor/autoload.php";

//THIS FILE SHOULD BE REQUIRED IN PAGES THAT REFERENCE THE GAME

// site class has all db config attributes (get email, set email, get/set db config)
$site = new Sorry\Site();

// localize.inc.php has closure function to 'hard code set' our site config stuff
// require creates this closure function and returns it
$localize = require 'localize.inc.php';

// if we can call it, call it with necessary param site (sets site stuff to belackch config)
if (is_callable($localize)) {
    $localize($site);
}

// Start the PHP session system
session_start();

define("SORRY_SESSION", 'sorry');

// If there is a Game session, get it. Otherwise, make a new one.
if(!isset($_SESSION[SORRY_SESSION])) {
    $board = new Sorry\Board([]);
    $_SESSION[SORRY_SESSION] = new Sorry\Game([], $board);
}

$sorry = $_SESSION[SORRY_SESSION];