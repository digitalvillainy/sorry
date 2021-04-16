<?php

require '../lib/sorry.inc.php';

$controller = new Sorry\PasswordValidateController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());