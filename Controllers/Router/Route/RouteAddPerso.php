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
        try {
            $data = [
                "name"      => $this->getParam($params, "perso-nom", false),
                "element"   => $this->getParam($params, "perso-element", false),
                "unitclass" => $this->getParam($params, "perso-unitclass", false),
                "origin"    => $this->getParam($params, "perso-origin", true),
                "rarity"    => (int)$this->getParam($params, "perso-rarity", false),
                // IMPORTANT : pas de snake_case pour l’hydratation -> urlImg
                "urlImg"    => $this->getParam($params, "perso-url-img", false),
            ];

            return $this->controller->addPerso($data);

        } catch (\Exception $e) {

            return $this->controller->displayAddPerso($e->getMessage());
        }
    }
}
