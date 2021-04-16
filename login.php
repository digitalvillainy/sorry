<?php
$open = true;
require 'lib/site.inc.php';

$view = new Sorry\LoginView($site);
$view->setTitle('Sorry Game Login Page');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head(); ?>

</head>

<body>
<div class="login">


    <header class="main">
        <h1>Sorry Game Login Page</h1>
    </header>

    <form>
        <fieldset>
            <legend>Login</legend>
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Email">
            </p>
            <p>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" placeholder="Password">
            </p>
            <p>
                <input type="submit" value="Log in"> <a href="">Lost Password</a>
            </p>
            <p class="link"><a href="create_account.php">Create New Account</a></p>
            <p><a href="./">Sorry Home Page</a></p>

        </fieldset>
    </form>

    <footer>
        <?php echo $view->footer(); ?>
    </footer>

</div>

</body>
</html>