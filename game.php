<?php
require 'lib/sorry.inc.php';
$view = new Sorry\SorryView($sorry);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sorry!</title>
    <link href="sorry.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <form method="post" action="sorry-post.php">
        <div class="game">
            <?php
            echo $view->displayCurrentTurn();
            echo $view->displayBoard();
            echo $view->displayCards();
            ?>
        </div>
        <input type="submit" value="Done" name="playerTurn">
        <input type="submit" value="New Game" name="clear">

    </form>
    <form action="how-to-play.html">
        <input type="submit" value="How to play" />
    </form>
    <div class ="win">
        <?php echo $view->displayWinner();
        ?>
    </div>
</body>
</html>
