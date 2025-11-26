<?php
namespace Models;

use PDO;
use PDOStatement;
use Config\Config;

/**
 * Class BasePDODAO
 * * Classe abstraite servant de parent à tous les DAO.
 * * Gère la connexion unique à la base de données et centralise
 * l'exécution des requêtes SQL via PDO pour éviter la duplication de code.
 */
abstract class BasePDODAO
{
    /** * @var ?PDO Instance de connexion PDO stockée pour réutilisation
     */
    private ?PDO $db = null;

    /**
     * Récupère l'instance de connexion PDO.
     * * Initialise la connexion si elle n'existe pas encore (Lazy loading)
     * en utilisant les paramètres définis dans la classe Config.
     *
     * @return PDO L'objet de connexion actif
     */
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

    /**
     * Exécute une requête SQL générique.
     * * Choisit automatiquement entre une requête directe (query) et une requête
     * préparée (prepare/execute) selon la présence de paramètres, pour garantir la sécurité.
     *
     * @param string     $sql    La requête SQL à exécuter
     * @param array|null $params Tableau des paramètres pour la requête préparée (optionnel)
     * @return PDOStatement Le résultat de la requête (Statement) prêt à être fetché
     */
    protected function execRequest(string $sql, array $params = null): PDOStatement
    {
        $pdo = $this->getDB();

        if ($params === null || $params === []) {
            // Pas de paramètres : requête simple
            $stmt = $pdo->query($sql);
            return $stmt;
        }

        // Paramètres présents : requête préparée
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}