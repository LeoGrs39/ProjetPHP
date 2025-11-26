<?php

namespace Models;

use Models\BasePDODAO;
use Models\Origin;
use PDO;

/**
 * Class OriginDAO
 * * Gère les opérations CRUD pour la table 'origin'.
 * Permet de manipuler les régions ou provenances des personnages (Mondstadt, Liyue, Inazuma, etc.).
 */
class OriginDAO extends BasePDODAO
{
    /**
     * Enregistre une nouvelle origine en base de données.
     *
     * @param Origin $origin L'objet origine à insérer
     * @return bool Vrai si l'exécution s'est bien passée, Faux sinon
     */
    public function create(Origin $origin): bool
    {
        $sql = "INSERT INTO origin (name, url_img) VALUES (?, ?)";
        $stmt = $this->execRequest($sql, [
            $origin->getName(),
            $origin->getUrlImg()
        ]);

        return $stmt !== false;
    }

    /**
     * Récupère la liste complète des origines existantes.
     * * Hydrate les résultats bruts en objets Origin.
     *
     * @return Origin[] Tableau d'objets Origin
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM origin";
        $stmt = $this->execRequest($sql);

        $list = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $origin = new Origin();
            $origin->hydrate($row);
            $list[] = $origin;
        }
        return $list;
    }

    /**
     * Cherche une origine spécifique par son identifiant.
     *
     * @param int $id Identifiant unique de l'origine
     * @return Origin|null L'objet Origin hydraté ou null si introuvable
     */
    public function getById(int $id): ?Origin
    {
        $sql = "SELECT * FROM origin WHERE id = ?";
        $stmt = $this->execRequest($sql, [$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $origin = new Origin();
        $origin->hydrate($row);
        return $origin;
    }
}