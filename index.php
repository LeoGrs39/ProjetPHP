<?php

use Helpers\Psr4AutoloaderClass;
use Controllers\Router\Router;

require_once "Helpers/Psr4AutoloaderClass.php";

$loader = new Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('\Helpers', 'Helpers');
$loader->addNamespace('\League\Plates', 'Vendor/Plates/src');
$loader->addNamespace('\Controllers', 'Controllers');
$loader->addNamespace('\Models', 'Models');
$loader->addNamespace('\Config', 'Config');
$loader->addNamespace('\Services', 'Services');


$router = new Router('action');

$router->routing($_GET, $_POST);
