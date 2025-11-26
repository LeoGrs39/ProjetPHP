<?php
namespace Controllers;

use League\Plates\Engine;
use Helpers\Message;
use Services\PersonnageService;
use Services\LogService;

/**
 * Class MainController
 * * Contrôleur principal gérant les pages générales de l'application
 * (Accueil, Visualisation des logs, etc.).
 */
class MainController
{
    private Engine $templates;

    /**
     * Constructeur du contrôleur.
     *
     * @param Engine $templates Moteur de template (Plates)
     */
    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    /**
     * Affiche la page d'accueil.
     * * Récupère la liste des personnages via le service dédié et gère
     * l'affichage des messages flash passés en GET.
     *
     * @return void
     */
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

    /**
     * Affiche l'interface de visualisation des fichiers de logs.
     *
     * Si un fichier spécifique est demandé, il tente de l'afficher.
     * Sinon, il affiche par défaut le fichier le plus récent.
     *
     * @param string|null $file Nom du fichier de log à afficher (optionnel)
     * @return void
     */
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