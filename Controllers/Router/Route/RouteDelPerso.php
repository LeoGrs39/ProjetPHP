<?php
namespace Controllers\Router\Route;

use Controllers\Router\Route;
use Controllers\PersoController;

class RouteDelPerso extends Route
{
    protected $controller;

    public function __construct(string $name, PersoController $controller)
    {
        parent::__construct($name, $controller);
        $this->controller = $controller;
    }


    public function get(array $params = [])
    {
        try {
            $idPerso = $this->getParam($params, 'idPerso', false);

            return $this->controller->deletePersoAndIndex($idPerso);

        } catch (\Exception $e) {
            return $this->controller->deletePersoAndIndex(null);
        }
    }

    public function post(array $params = [])
    {
        return $this->get($params);
    }
}
