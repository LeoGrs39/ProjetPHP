<?php
namespace Controllers;

use League\Plates\Engine;
use Models\PersonnageDAO;

class MainController
{

    private Engine $templates;

    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    public function index(): void
    {
        $dao = new PersonnageDAO();

        $listPersonnage = $dao->getAll();

        $first = null;
        $existing = null;
        if (!empty($listPersonnage)) {
            $first = $listPersonnage[0];
            $existing = $dao->getByID($first->getId());
        }

        $other = $dao->getByID('does-not-exist-123');

        echo $this->templates->render('home', [
            'gameName'       => 'Genshin Impact',
            'listPersonnage' => $listPersonnage,
            'first'          => $existing,
            'other'          => $other,
        ]);
    }
}
