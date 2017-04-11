<?php

define('ROOT_PATH', realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR);

include ROOT_PATH . 'vendor/autoload.php';

new pxgamer\KatRevive\Routing\Routing();