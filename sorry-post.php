<?php
require __DIR__ . '/lib/sorry.inc.php';
$controller = new \Sorry\SorryController($sorry, $_POST);
//echo "Controller Reset? : " . print_r($_POST);
//print_r($_POST);
header("location: game.php");
exit;
//echo "<a href='game.php'>Go To Game</a>";
