<?php
require __DIR__ . '/lib/sorry.inc.php';
$controller = new \Sorry\StartController($_POST);
$players = $controller->getPlayers();
if (count($players) > 1) {
    $newBoard = new \Sorry\Board($players);
    $newGame = new \Sorry\Game($players, $newBoard);
    //Not entirely sure how to handle the session as it is assigned in sorry.inc.php,
    //so I am just reassigning the session in this file if the criteria to play is met.
    $sorry = $newGame;
    $_SESSION[SORRY_SESSION] = $sorry;
    //echo '<a href="game.php">Go To Game</a>';
    //print_r($_POST);
    header("location: game.php");
    exit;
}
else {
    header("location: index.php");
    exit;
}
//echo "<a href='index.php'>To Index</a>";
//echo "<a href='game.php'>To Game</a>";