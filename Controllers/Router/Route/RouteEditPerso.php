<?php
namespace Controllers\Router\Route;

use Controllers\Router\Route;

class RouteEditPerso extends Route
{
    public function __construct(string $name)
    {
        parent::__construct($name, null);
    }

    public function get(array $params = [])
    {
        try {
            $id = $this->getParam($params, 'id', false);

            header('Location: index.php?action=add-perso&id=' . urlencode($id));
            exit;
        } catch (\Exception $e) {
            header('Location: index.php?action=add-perso');
            exit;
        }
    }

    public function post(array $params = [])
    {
        return $this->get($params);
    }
}
