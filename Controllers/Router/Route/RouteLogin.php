<?php

namespace Controllers\Router\Route;

use Controllers\AuthController;
use Controllers\Router\Route as BaseRoute;

class RouteLogin extends BaseRoute
{
    /**
     * GET / index.php?action=login
     * Affiche le formulaire de connexion.
     *
     * @param array $params
     */
    public function get(array $params = [])
    {
        /** @var AuthController $ctrl */
        $ctrl = $this->controller;
        $ctrl->showLoginForm();
    }

    /**
     * POST / index.php?action=login
     * Traite le formulaire de connexion.
     *
     * @param array $params
     */
    public function post(array $params = [])
    {
        /** @var AuthController $ctrl */
        $ctrl = $this->controller;
        $ctrl->handleLogin($params);
    }
}
