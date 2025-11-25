<?php
namespace Controllers;

use League\Plates\Engine;
use Helpers\Message;
use Services\PersonnageService;
use Services\LogService;

class MainController
{
    private Engine $templates;

    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    public function index(): void
    {
        $service        = new PersonnageService();
        $listPersonnage = $service->getAllPerso();

        $raw     = $_GET['message'] ?? null;
        $message = null;

        if ($raw !== null && $raw !== '') {
            $maybe = @unserialize($raw);
            if ($maybe instanceof Message) {
                $message = $maybe;
            } else {
                $message = new Message((string) $raw);
            }
        }

        echo $this->templates->render('home', [
            'gameName'       => 'Genshin Impact',
            'listPersonnage' => $listPersonnage,
            'personnages'    => $listPersonnage,
            'message'        => $message,
        ]);
    }

    public function displayLogs(?string $file = null): void
    {
        $logService = new LogService();

        $logFiles = $logService->listLogFiles();
        $selectedFile = null;
        $logContent   = null;

        if ($file !== null && in_array($file, $logFiles, true)) {
            $selectedFile = $file;
            $logContent   = $logService->readLogFile($file);
        } elseif (!empty($logFiles)) {
            // si aucun fichier demandé, on affiche le plus récent
            $selectedFile = $logFiles[0];
            $logContent   = $logService->readLogFile($selectedFile);
        }

        echo $this->templates->render('logs', [
            'title'        => 'Logs',
            'logFiles'     => $logFiles,
            'selectedFile' => $selectedFile,
            'logContent'   => $logContent,
        ]);
    }
}
