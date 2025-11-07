<?php
namespace Controllers\Router;

abstract class Route
{

    protected string $name = '';
    protected $controller = null;

    public function __construct(string $name = '', $controller = null)
    {
        $this->name = $name;
        $this->controller = $controller;
    }

    public function action(array $params = [], string $method = 'GET')
    {
        $method = strtoupper($method);
        if ($method === 'POST') {
            return $this->post($params);
        }
        return $this->get($params);
    }

    protected function getParam(array $array, string $paramName, bool $canBeEmpty = true)
    {
        if (isset($array[$paramName])) {
            if (!$canBeEmpty && empty($array[$paramName])) {
                throw new \Exception("Paramètre '$paramName' vide");
            }
            return $array[$paramName];
        }
        throw new \Exception("Paramètre '$paramName' absent");
    }

    abstract public function get(array $params = []);
    abstract public function post(array $params = []);
}
