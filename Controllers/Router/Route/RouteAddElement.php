<?php
namespace Controllers\Router\Route;

use Controllers\Router\Route;
use Controllers\PersoController;

class RouteAddElement extends Route
{
    protected $controller;

    public function __construct(string $name, PersoController $controller)
    {
        parent::__construct($name, $controller);
        $this->controller = $controller;
    }

    public function get(array $params = [])
    {
        return $this->controller->displayAddElement();
    }

    public function post(array $params = [])
    {
        // Rien pour le moment, on réutilise le GET
        return $this->get($params);
    }
}
