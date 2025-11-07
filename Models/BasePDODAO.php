<?php
namespace Models;

use PDO;
use PDOStatement;
use Config\Config;

abstract class BasePDODAO
{
    /** @var ?PDO */
    private ?PDO $db = null;


    protected function getDB(): PDO
    {
        if ($this->db === null) {

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

    protected function execRequest(string $sql, array $params = null): PDOStatement
    {
        $pdo = $this->getDB();

        if ($params === null || $params === []) {

            $stmt = $pdo->query($sql);
            return $stmt;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}