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

    /**
     * Affiche le formulaire pré-rempli pour l'édition.
     * URL attendue : index.php?action=edit-perso&idPerso=xxxx
     */
    public function get(array $params = [])
    {
        try {
            // Récupération de l'idPerso dans l'URL
            $idPerso = $this->getParam($params, 'idPerso', false);

            return $this->controller->displayEditPerso($idPerso);
        } catch (\Exception $e) {
            // Si le paramètre idPerso est manquant ou vide
            return $this->controller->displayAddPerso("id not found");
        }
    }

    public function post(array $params = [])
    {
        try {
            $data = [
                "id"        => $this->getParam($params, "perso-id", false),
                "name"      => $this->getParam($params, "perso-nom", false),
                "element"   => $this->getParam($params, "perso-element", false),
                "unitclass" => $this->getParam($params, "perso-unitclass", false),
                "origin"    => $this->getParam($params, "perso-origin", true),
                "rarity"    => (int)$this->getParam($params, "perso-rarity", false),
                "urlImg"    => $this->getParam($params, "perso-url-img", false),
            ];

            return $this->controller->editPersoAndIndex($data);

        } catch (\Exception $e) {
            // En cas d’oubli d’un paramètre
            return $this->controller->displayAddPerso("Modification impossible : " . $e->getMessage());
        }
    }
}
