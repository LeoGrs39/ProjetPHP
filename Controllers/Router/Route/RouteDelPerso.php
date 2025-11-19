<?php
namespace Controllers\Router\Route;

use Controllers\Router\Route;

class RouteDelPerso extends Route
{
    public function __construct(string $name)
    {
        parent::__construct($name, null);
    }

    public function get(array $params = [])
    {
        try {
            $id = $this->getParam($params, 'id', false);
            $message = "Suppression fictive du personnage $id (partie 3, pas encore en BD).";
        } catch (\Exception $e) {
            $message = "Suppression fictive du personnage.";
        }

        header('Location: index.php?message=' . urlencode($message));
        exit;
    }

    public function post(array $params = [])
    {
        return $this->get($params);
    }
}
