<?php
require 'lib/sorry.inc.php';
$view = new Sorry\PasswordValidateView($site, $_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head(); ?>
</head>

<body>
<div class="password">

    <?php
    echo $view->header();
    ?>

    <?php
    echo $view->present();
    ?>

    <?php
    echo $view->footer();
    ?>

</div>

</body>
</html>
