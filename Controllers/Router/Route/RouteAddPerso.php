<?php
namespace Controllers\Router\Route;

use Controllers\Router\Route;
use Controllers\PersoController;

class RouteAddPerso extends Route
{
    protected $controller;

    public function __construct(string $name, PersoController $controller)
    {
        parent::__construct($name, $controller);
        $this->controller = $controller;
    }

    public function get(array $params = [])
    {
        return $this->controller->displayAddPerso();
    }

    public function post(array $params = [])
    {
        return $this->get($params);
    }
}
