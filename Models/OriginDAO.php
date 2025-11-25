<?php

namespace Models;

use Models\BasePDODAO;
use Models\Origin;
use PDO;

class OriginDAO extends BasePDODAO
{
    public function create(Origin $origin): bool
    {
        $sql = "INSERT INTO origin (name, url_img) VALUES (?, ?)";
        $stmt = $this->execRequest($sql, [
            $origin->getName(),
            $origin->getUrlImg()
        ]);

        return $stmt !== false;
    }

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