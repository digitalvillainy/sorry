<?php
$open = true;
require 'lib/site.inc.php';

$view = new Sorry\LoginView($site);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head(); ?>
</head>
<body>
<div class="login">


    <header class="main">
        <h1>Sorry Game Create Account Page</h1>
    </header>

    <form>
        <fieldset>
            <legend>Create Account</legend>
            <p>
                <label for="username">Username</label><br>
                <input type="username" id="username" name="username" placeholder="Username">
            </p>
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Email">
            </p>
            <p>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" placeholder="Password">
            </p>
            <p>
                <input type="submit" value="Create Account">
            </p>
            <p class="link"><a href="login.php">Click to Login</a></p>

        </fieldset>
    </form>

    <footer>
        <?php echo $view->footer(); ?>
    </footer>

</div>

</body>
</html>
