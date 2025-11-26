<?php

namespace Models;

use Models\BasePDODAO;
use Models\UnitClass;
use PDO;

/**
 * Class UnitClassDAO
 * * Gère les opérations CRUD pour la table 'unitclass'.
 * Permet de manipuler les classes de personnages ou types d'armes (Épée, Arc, Catalyseur, etc.).
 */
class UnitClassDAO extends BasePDODAO
{
    /**
     * Enregistre une nouvelle classe d'unité en base de données.
     *
     * @param UnitClass $unitClass L'objet classe à insérer
     * @return bool Vrai si l'insertion a réussi, Faux sinon
     */
    public function create(UnitClass $unitClass): bool
    {
        $sql = "INSERT INTO unitclass (name, url_img) VALUES (?, ?)";
        $stmt = $this->execRequest($sql, [
            $unitClass->getName(),
            $unitClass->getUrlImg()
        ]);

        return $stmt !== false;
    }

    /**
     * Récupère la liste complète des classes d'unités.
     * * Hydrate les résultats bruts en objets UnitClass.
     *
     * @return UnitClass[] Tableau d'objets UnitClass
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM unitclass";
        $stmt = $this->execRequest($sql);

        $list = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $u = new UnitClass();
            $u->hydrate($row);
            $list[] = $u;
        }

        return $list;
    }

    /**
     * Cherche une classe d'unité spécifique par son identifiant.
     *
     * @param int $id Identifiant unique de la classe
     * @return UnitClass|null L'objet UnitClass hydraté ou null si introuvable
     */
    public function getById(int $id): ?UnitClass
    {
        $sql = "SELECT * FROM unitclass WHERE id = ?";
        $stmt = $this->execRequest($sql, [$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $u = new UnitClass();
        $u->hydrate($row);
        return $u;
    }
}