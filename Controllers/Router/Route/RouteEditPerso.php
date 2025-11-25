<?php
namespace Controllers\Router\Route;

use Controllers\Router\Route;
use Controllers\PersoController;

class RouteEditPerso extends Route
{
    protected $controller;

    public function __construct(string $name, PersoController $controller)
    {
        parent::__construct($name, $controller);
        $this->controller = $controller;
    }

    public function get(array $params = [])
    {
        $idPerso = $this->getParam($params, 'idPerso', false);
        return $this->controller->displayEditPerso($idPerso);
    }

    public function post(array $params = [])
    {
        try {
            $id       = $this->getParam($params, "perso-id", false);
            $name     = $this->getParam($params, "perso-nom", false);
            $element  = $this->getParam($params, "perso-element", false);
            $unitcl   = $this->getParam($params, "perso-unitclass", false);
            $originRaw= $this->getParam($params, "perso-origin", true);
            $rarity   = $this->getParam($params, "perso-rarity", false);
            $urlImg   = $this->getParam($params, "perso-url-img", false);

            $data = [
                "id"        => $id,
                "name"      => $name,
                "element"   => intval($element),
                "unitclass" => intval($unitcl),
                "origin"    => ($originRaw === '' || $originRaw === null) ? null : intval($originRaw),
                "rarity"    => (int)$rarity,
                "urlImg"    => $urlImg,
            ];

            return $this->controller->editPersoAndIndex($data);

        } catch (\Exception $e) {
            $idPerso = $params['perso-id'] ?? ($params['idPerso'] ?? '');
            return $this->controller->displayEditPerso((string)$idPerso, $e->getMessage());
        }
    }
}
