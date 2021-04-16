<?php
require 'lib/sorry.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sorry!</title>
    <link href="sorry.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <p>Sorry!</p>
    <form id="playerSelection" method="post" action="start-post.php">
        <input type="checkbox" id="redCheck" name="red" value="red">
        <label for="redCheck">Red</label>
        <input type="checkbox" id="greenCheck" name="green" value="green">
        <label for="greenCheck">Green</label>
        <input type="checkbox" id="blueCheck" name="blue" value="blue">
        <label for="blueCheck">Blue</label>
        <input type="checkbox" id="yellowCheck" name="yellow" value="yellow">
        <label for="yellowCheck">Yellow</label>
        <input type="submit">
    </form>
    <p>You must select at least two colors to play</p>
    <a href="how-to-play.html">
        <input name="instructions" type="submit" value="How To Play"/>
    </a>

</body>
</html>