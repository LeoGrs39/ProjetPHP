<?php
namespace Models;

class PersonnageDAO extends BasePDODAO
{
    /** @return Personnage[] */
    public function getAll(): array
    {
        $sql  = "SELECT id, name, element, unitclass, origin, rarity, url_img AS urlImg
                 FROM PERSONNAGE";
        $rows = $this->execRequest($sql)->fetchAll();
        return array_map([$this, 'mapRowToEntity'], $rows);
    }

    public function getByID(string $idPersonnage): ?Personnage
    {
        $sql  = "SELECT id, name, element, unitclass, origin, rarity, url_img AS urlImg
                 FROM PERSONNAGE WHERE id = ?";
        $stmt = $this->execRequest($sql, [$idPersonnage]);
        $row  = $stmt->fetch();
        return $row ? $this->mapRowToEntity($row) : null;
    }

    private function mapRowToEntity(array $row): Personnage
    {
        $p = new Personnage();
        $p->hydrate($row);
        return $p;
    }
}
