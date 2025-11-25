<?php

namespace Services;

class LogService
{
    private string $logDir;
    private const PREFIX = 'MIHOYO_';

    public function __construct(?string $logDir = null)
    {
        $this->logDir = $logDir ?? dirname(__DIR__) . DIRECTORY_SEPARATOR . 'logs';
    }

    private function ensureDirectoryExists(): void
    {
        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0777, true);
        }
    }


    public function log(string $action, string $message, bool $success): void
    {
        $this->ensureDirectoryExists();

        $now = new \DateTimeImmutable('now');

        $filename = sprintf(
            '%s%02d_%04d.log',
            self::PREFIX,
            (int)$now->format('m'),
            (int)$now->format('Y')
        );
        $path = $this->logDir . DIRECTORY_SEPARATOR . $filename;

        $status = $success ? 'SUCCESS' : 'ERROR';

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
     * @return string[] Liste des fichiers de log (basenames) triés du plus récent au plus ancien.
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


    public function readLogFile(string $basename): ?string
    {
        $this->ensureDirectoryExists();

        if (strpos($basename, DIRECTORY_SEPARATOR) !== false || strpos($basename, '..') !== false) {
            return null;
        }

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
