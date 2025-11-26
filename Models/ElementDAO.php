<?php

namespace Models;

use Models\BasePDODAO;
use Models\Element;
use PDO;

/**
 * Class ElementDAO
 * * Gère les opérations CRUD pour la table 'element'.
 * Permet de manipuler les attributs élémentaires (Pyro, Hydro, Anemo, etc.).
 */
class ElementDAO extends BasePDODAO
{
    /**
     * Enregistre un nouvel élément en base de données.
     *
     * @param Element $element L'objet élément à insérer (avec nom et image)
     * @return bool Vrai si la requête a réussi (statement retourné), Faux sinon
     */
    public function create(Element $element): bool
    {
        $sql = "INSERT INTO element (name, url_img) VALUES (?, ?)";
        $stmt = $this->execRequest($sql, [
            $element->getName(),
            $element->getUrlImg()
        ]);

        return $stmt !== false;
    }

    /**
     * Récupère la liste complète des éléments existants.
     * * Instancie et hydrate des objets Element pour chaque ligne trouvée.
     *
     * @return Element[] Tableau d'objets Element
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM element";
        $stmt = $this->execRequest($sql);

        $elements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $e = new Element();
            $e->hydrate($row);
            $elements[] = $e;
        }

        return $elements;
    }

    /**
     * Cherche un élément spécifique par son identifiant numérique.
     *
     * @param int $id Identifiant unique de l'élément
     * @return Element|null L'objet Element hydraté ou null si l'ID n'existe pas
     */
    public function getById(int $id): ?Element
    {
        $sql = "SELECT * FROM element WHERE id = ?";
        $stmt = $this->execRequest($sql, [$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $e = new Element();
        $e->hydrate($row);
        return $e;
    }
}