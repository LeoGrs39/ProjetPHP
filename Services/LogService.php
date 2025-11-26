<?php

namespace Services;

/**
 * Class LogService
 * * Service responsable de la gestion des fichiers de logs (journaux d'événements).
 * * Permet d'écrire de nouvelles entrées et de lire l'historique existant.
 */
class LogService
{
    private string $logDir;

    /** @var string Préfixe des fichiers de logs (thématique Genshin) */
    private const PREFIX = 'MIHOYO_';

    /**
     * Constructeur du service de log.
     *
     * @param string|null $logDir Chemin vers le dossier de logs. Si null, utilise un dossier 'logs' à la racine du projet.
     */
    public function __construct(?string $logDir = null)
    {
        $this->logDir = $logDir ?? dirname(__DIR__) . DIRECTORY_SEPARATOR . 'logs';
    }

    /**
     * Vérifie l'existence du dossier de logs et le crée si nécessaire.
     *
     * @return void
     */
    private function ensureDirectoryExists(): void
    {
        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0777, true);
        }
    }

    /**
     * Enregistre une nouvelle ligne de log.
     * * Le fichier cible est déterminé par le mois et l'année courants (ex: MIHOYO_11_2023.log).
     *
     * @param string $action  Le type d'action (ex: CREATE_PERSO, LOGIN, etc.)
     * @param string $message Le détail de l'événement ou de l'erreur
     * @param bool   $success Indique si l'action a réussi (true) ou échoué (false)
     * @return void
     */
    public function log(string $action, string $message, bool $success): void
    {
        $this->ensureDirectoryExists();

        $now = new \DateTimeImmutable('now');

        // Génère un nom de fichier par mois (ex: MIHOYO_11_2025.log)
        $filename = sprintf(
            '%s%02d_%04d.log',
            self::PREFIX,
            (int)$now->format('m'),
            (int)$now->format('Y')
        );
        $path = $this->logDir . DIRECTORY_SEPARATOR . $filename;

        $status = $success ? 'SUCCESS' : 'ERROR';

        // Format de la ligne : [DATE HEURE] [ACTION] [STATUS] Message
        $line = sprintf(
            "[%s] [%s] [%s] %s%s",
            $now->format('Y-m-d H:i:s'),
            strtoupper($action),
            $status,
            $message,
            PHP_EOL
        );

        file_put_contents($path, $line, FILE_APPEND);
    }

    /**
     * Récupère la liste des fichiers de log disponibles.
     *
     * @return string[] Liste des noms de fichiers (basenames) triés du plus récent au plus ancien.
     */
    public function listLogFiles(): array
    {
        $this->ensureDirectoryExists();

        $pattern = $this->logDir . DIRECTORY_SEPARATOR . self::PREFIX . '*.log';
        $files   = glob($pattern) ?: [];

        $basenames = array_map('basename', $files);
        rsort($basenames); // plus récent d'abord

        return $basenames;
    }

    /**
     * Lit le contenu complet d'un fichier de log spécifique.
     * * Inclut des sécurités pour empêcher la lecture de fichiers hors du dossier (Directory Traversal).
     *
     * @param string $basename Le nom du fichier à lire (ex: MIHOYO_11_2025.log)
     * @return string|null Le contenu du fichier ou null si le fichier est invalide ou inexistant.
     */
    public function readLogFile(string $basename): ?string
    {
        $this->ensureDirectoryExists();

        // Sécurité : Empêche de remonter dans les dossiers (../)
        if (strpos($basename, DIRECTORY_SEPARATOR) !== false || strpos($basename, '..') !== false) {
            return null;
        }

        // Sécurité : Vérifie que le fichier commence bien par le préfixe attendu
        if (strpos($basename, self::PREFIX) !== 0) {
            return null;
        }

        $path = $this->logDir . DIRECTORY_SEPARATOR . $basename;

        if (!is_file($path)) {
            return null;
        }

        return file_get_contents($path) ?: '';
    }
}