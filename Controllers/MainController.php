<?php
namespace Controllers;

use League\Plates\Engine;
use Models\PersonnageDAO;
use Helpers\Message;

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

        $first    = null;
        $existing = null;
        if (!empty($listPersonnage)) {
            $first    = $listPersonnage[0];
            $existing = $dao->getByID($first->getId());
        }

        $other = $dao->getByID('does-not-exist-123');

        // message éventuel (objet sérialisé ou string)
        $raw = $_GET['message'] ?? null;
        $message = null;

        if ($raw !== null && $raw !== '') {
            $maybe = @unserialize($raw);
            if ($maybe instanceof Message) {
                $message = $maybe;
            } else {
                // fallback : juste un texte => message info par défaut
                $message = new Message((string)$raw);
            }
        }

        echo $this->templates->render('home', [
            'gameName'       => 'Genshin Impact',
            'listPersonnage' => $listPersonnage,
            'first'          => $existing,
            'other'          => $other,
            'message'        => $message,
        ]);
    }

    public function displayLogs(): void
    {
        echo $this->templates->render('logs', [
            'title' => 'Logs',
        ]);
    }
}
