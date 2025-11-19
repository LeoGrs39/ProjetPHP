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

        // message éventuel (utilisé plus tard pour delete, etc.)
        $message = $_GET['message'] ?? null;

        echo $this->templates->render('home', [
            'gameName'       => 'Genshin Impact',
            'listPersonnage' => $listPersonnage,
            'first'          => $existing,
            'other'          => $other,
            'message'        => $message,
        ]);
    }

    /**
     * Page logs / recherche (Partie 3)
     */
    public function displayLogs(): void
    {
        echo $this->templates->render('logs', [
            'title' => 'Logs',
        ]);
    }
}
