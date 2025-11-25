<?php
namespace Controllers\Router;

use Controllers\MainController;
use Controllers\PersoController;
use Controllers\Router\Route\RouteIndex;
use Controllers\Router\Route\RouteAddPerso;
use Controllers\Router\Route\RouteAddElement;
use Controllers\Router\Route\RouteLogs;
use Controllers\Router\Route\RouteEditPerso;
use Controllers\Router\Route\RouteDelPerso;

class Router
{
    /** @var array<string,Route> */
    protected array $routeList = [];
    /** @var array<string,object> */
    protected array $ctrlList = [];
    protected string $action_key;

    public function __construct(string $name_of_action_key = 'action')
    {
        $this->action_key = $name_of_action_key;
        $this->createControllerList();
        $this->createRouteList();
    }


    protected function createControllerList(): void
    {
        $templates = new \League\Plates\Engine(dirname(__DIR__, 2) . '/Views');

        $this->ctrlList['main']  = new MainController($templates);
        $this->ctrlList['perso'] = new PersoController($templates);
    }

    protected function createRouteList(): void
    {
        $this->routeList['index']             = new RouteIndex('index', $this->ctrlList['main']);
        $this->routeList['add-perso']         = new RouteAddPerso('add-perso', $this->ctrlList['perso']);
        $this->routeList['add-perso-element'] = new RouteAddElement('add-perso-element', $this->ctrlList['perso']);
        $this->routeList['logs']              = new RouteLogs('logs', $this->ctrlList['main']);

        // actions sans vue dédiée
        $this->routeList['edit-perso']        = new RouteEditPerso('edit-perso', $this->ctrlList['perso']);
        $this->routeList['del-perso']         = new RouteDelPerso('del-perso', $this->ctrlList['perso']);
    }

    public function routing(array $get, array $post): void
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        $action = $get[$this->action_key] ?? 'index';

        $route = $this->routeList[$action] ?? $this->routeList['index'] ?? null;

        if (!$route) {
            header('HTTP/1.1 302 Found');
            header('Location: index.php');
            exit;
        }

        $params = ($method === 'POST') ? $post : $get;

        $route->action($params, $method);
    }
}
