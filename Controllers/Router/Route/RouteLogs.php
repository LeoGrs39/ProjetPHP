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
        return $this->controller->displayLogs();
    }

    public function post(array $params = [])
    {
        // Logs en lecture seule pour l’instant, même comportement
        return $this->get($params);
    }
}