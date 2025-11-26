<?php

namespace Controllers\Router\Route;

use Controllers\AuthController;
use Controllers\Router\Route as BaseRoute;

class RouteLogout extends BaseRoute
{
    /**
     * GET / index.php?action=logout
     * Déconnecte puis redirige.
     *
     * @param array $params
     */
    public function get(array $params = [])
    {
        /** @var AuthController $ctrl */
        $ctrl = $this->controller;
        $ctrl->logout();
    }

    /**
     * POST / index.php?action=logout
     * (au cas où) même comportement que GET.
     *
     * @param array $params
     */
    public function post(array $params = [])
    {
        /** @var AuthController $ctrl */
        $ctrl = $this->controller;
        $ctrl->logout();
    }
}
