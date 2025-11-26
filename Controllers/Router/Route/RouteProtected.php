<?php

namespace Controllers\Router\Route;

use Controllers\AuthController;
use Controllers\Router\Route as BaseRoute;

class RouteProtected extends BaseRoute
{
    /**
     * GET / index.php?action=protected
     * Affiche la page protégée.
     *
     * @param array $params
     */
    public function get(array $params = [])
    {
        /** @var AuthController $ctrl */
        $ctrl = $this->controller;
        $ctrl->showProtected();
    }

    /**
     * POST / index.php?action=protected
     *
     * @param array $params
     */
    public function post(array $params = [])
    {
        /** @var AuthController $ctrl */
        $ctrl = $this->controller;
        $ctrl->showProtected();
    }
}
