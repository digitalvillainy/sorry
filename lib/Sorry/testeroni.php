<?php

use JsonUtil\JsonUtil;

require_once "../../vendor/autoload.php";

$file = JsonUtil::extract('../../gamestate.json');

$file['players']['red']['a']['safe'] = false;

$update = JsonUtil::insert($file, '../../gamestate.json');

echo '<pre/>';
var_dump($file['players']['red']['a']['safe']);
die();