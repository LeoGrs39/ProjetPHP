<?php

namespace Models;

use Models\BasePDODAO;
use Models\UnitClass;
use PDO;

class UnitClassDAO extends BasePDODAO
{
    public function create(UnitClass $unitClass): bool
    {
        $sql = "INSERT INTO unitclass (name, url_img) VALUES (?, ?)";
        $stmt = $this->execRequest($sql, [
            $unitClass->getName(),
            $unitClass->getUrlImg()
        ]);

        return $stmt !== false;
    }

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
