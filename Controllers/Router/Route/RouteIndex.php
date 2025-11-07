<?php
namespace Controllers\Router\Route;

use Controllers\Router\Route;
use Controllers\MainController;

class RouteIndex extends Route
{
    protected $controller;

    public function __construct(string $name, MainController $controller)
    {
        parent::__construct($name, $controller);
        $this->controller = $controller;
    }

    public function get(array $params = [])
    {
        return $this->controller->index();
    }

    public function post(array $params = [])
    {
        return $this->controller->index();
    }
}
