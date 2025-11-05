<?php

use Controllers\MainController;
use Helpers\Psr4AutoloaderClass;

require_once "Helpers/Psr4AutoloaderClass.php";

$loader = new Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('\Helpers', '/Helpers');
$loader->addNamespace('\League\Plates', '/Vendor/Plates/src');
$loader->addNamespace('\Controllers', '/Controllers');

$templates = new \League\Plates\Engine(__DIR__ . '/Views');

$controller = new MainController($templates);
$controller->index();
