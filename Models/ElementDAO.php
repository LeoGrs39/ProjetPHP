<?php

namespace Models;

use Models\BasePDODAO;
use Models\Element;
use PDO;

class ElementDAO extends BasePDODAO
{
    public function create(Element $element): bool
    {
        $sql = "INSERT INTO element (name, url_img) VALUES (?, ?)";
        $stmt = $this->execRequest($sql, [
            $element->getName(),
            $element->getUrlImg()
        ]);

        return $stmt !== false;
    }

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