<?php
namespace Models;

use PDO;
use PDOStatement;
use Config\Config;

abstract class BasePDODAO
{
    /** @var ?PDO */
    private ?PDO $db = null;

    /**
     * Retourne une instance PDO (l’instancie une seule fois).
     */
    protected function getDB(): PDO
    {
        if ($this->db === null) {
            // Récup des infos depuis Config (chargée via parse_ini_file)
            // INI attendu (extrait) :
            // [DB]
            // dsn='mysql:host=localhost;dbname=YOURDBNAME;charset=utf8'
            // user='YOUR_USERNAME'
            // pass='YOUR_PASSWORD'
            $dsn  = Config::get('dsn');
            $user = Config::get('user');
            $pass = Config::get('pass');

            $this->db = new PDO(
                $dsn,
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            );
        }
        return $this->db;
    }

    /**
     * Exécute une requête SQL.
     * - Sans $params -> query simple
     * - Avec $params -> requête préparée
     * Retourne toujours le PDOStatement résultant.
     */
    protected function execRequest(string $sql, array $params = null): PDOStatement
    {
        $pdo = $this->getDB();

        if ($params === null || $params === []) {
            // Requête directe
            $stmt = $pdo->query($sql);
            return $stmt;
        }

        // Requête préparée
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}