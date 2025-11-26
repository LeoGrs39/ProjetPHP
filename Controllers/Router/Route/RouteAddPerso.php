<?php
namespace Controllers\Router\Route;

use Controllers\Router\Route;
use Controllers\PersoController;

/**
 * Class RouteAddPerso
 * * Route spécifique gérant la page d'ajout de personnage.
 * * Elle fait le lien entre la requête HTTP (GET/POST) et le contrôleur PersoController.
 */
class RouteAddPerso extends Route
{
    /**
     * @var PersoController Le contrôleur spécifique à cette route
     */
    protected $controller;

    /**
     * Constructeur de la route d'ajout.
     *
     * @param string $name Nom de la route (pour le routage interne)
     * @param PersoController $controller Instance du contrôleur
     */
    public function __construct(string $name, PersoController $controller)
    {
        parent::__construct($name, $controller);
        $this->controller = $controller;
    }

    /**
     * Exécute la logique pour une requête GET.
     * * Affiche le formulaire d'ajout via le contrôleur.
     *
     * @param array $params Paramètres de la requête (non utilisé ici)
     * @return mixed Résultat de l'affichage
     */
    public function get(array $params = [])
    {
        return $this->controller->displayAddPerso();
    }

    /**
     * Exécute la logique pour une requête POST.
     * * Récupère les champs du formulaire, les formate (intval, etc.) et appelle
     * la méthode d'ajout du contrôleur.
     *
     * @param array $params Données soumises via le formulaire ($_POST)
     * @return mixed Résultat du traitement ou réaffichage du formulaire en cas d'erreur
     */
    public function post(array $params = [])
    {
        try {
            // Récupération sécurisée des paramètres via la méthode parente getParam
            $name      = $this->getParam($params, "perso-nom", false);
            $element   = $this->getParam($params, "perso-element", false);
            $unitclass = $this->getParam($params, "perso-unitclass", false);
            $originRaw = $this->getParam($params, "perso-origin", true); // true = peut être vide
            $rarity    = $this->getParam($params, "perso-rarity", false);
            $urlImg    = $this->getParam($params, "perso-url-img", false);

            // Préparation du tableau de données typé pour le Service/Contrôleur
            $data = [
                "name"      => $name,
                "element"   => intval($element),
                "unitclass" => intval($unitclass),
                "origin"    => ($originRaw === '' || $originRaw === null) ? null : intval($originRaw),
                "rarity"    => (int)$rarity,
                "urlImg"    => $urlImg,
            ];

            return $this->controller->addPerso($data);

        } catch (\Exception $e) {
            // En cas d'erreur de récupération, on réaffiche le formulaire avec l'erreur
            return $this->controller->displayAddPerso($e->getMessage());
        }
    }
}