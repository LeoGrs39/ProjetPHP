<?php

use Helpers\Psr4AutoloaderClass;
use Controllers\Router\Router;

require_once "Helpers/Psr4AutoloaderClass.php";

$loader = new Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('\Helpers', '/Helpers');
$loader->addNamespace('\League\Plates', '/Vendor/Plates/src');
$loader->addNamespace('\Controllers', '/Controllers');
$loader->addNamespace('\Models', '/Models');
$loader->addNamespace('\Config', '/Config');

// Instancie le routeur avec la clé d'action "action"
$router = new Router('action');

// Démarre l'aiguillage en lui passant GET/POST
$router->routing($_GET, $_POST);
