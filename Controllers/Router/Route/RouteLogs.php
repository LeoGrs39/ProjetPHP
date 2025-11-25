<?php
namespace Controllers\Router\Route;

use Controllers\Router\Route;
use Controllers\MainController;

class RouteLogs extends Route
{
    protected $controller;

    public function __construct(string $name, MainController $controller)
    {
        parent::__construct($name, $controller);
        $this->controller = $controller;
    }

    public function get(array $params = [])
    {
        $file = $params['file'] ?? null;
        return $this->controller->displayLogs($file);
    }

    public function post(array $params = [])
    {
        return $this->get($params);
    }
}
