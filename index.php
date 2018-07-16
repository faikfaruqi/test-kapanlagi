<?php
require_once __DIR__ . "/AutoLoader.php";
require_once __DIR__ . '/vendor/autoload.php';
use lib\MVC\Router;

$kernel = new Router($_GET);
$controller = $kernel->getController();
$controller->ExecuteAction();