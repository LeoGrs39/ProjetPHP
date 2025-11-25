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

    public function createPersonnage(Personnage $personnage): void
    {
        $sql = "INSERT INTO PERSONNAGE (id, name, element, unitclass, origin, rarity, url_img)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $personnage->getId(),
            $personnage->getName(),
            $personnage->getElement(),
            $personnage->getUnitclass(),
            $personnage->getOrigin(),
            $personnage->getRarity(),
            $personnage->getUrlImg(),
        ];

        $this->execRequest($sql, $params);
    }

    public function deletePerso(?string $idPerso = null): int
    {
        if ($idPerso === null) {
            return 0;
        }

        $sql  = "DELETE FROM PERSONNAGE WHERE id = ?";
        $stmt = $this->execRequest($sql, [$idPerso]);

        return $stmt->rowCount();
    }

    private function mapRowToEntity(array $row): Personnage
    {
        $p = new Personnage();
        $p->hydrate($row);
        return $p;
    }

    public function updatePersonnage(Personnage $perso): int
    {
        $sql = "UPDATE PERSONNAGE 
            SET name = ?, element = ?, unitclass = ?, origin = ?, rarity = ?, url_img = ?
            WHERE id = ?";

        $params = [
            $perso->getName(),
            $perso->getElement(),
            $perso->getUnitclass(),
            $perso->getOrigin(),
            $perso->getRarity(),
            $perso->getUrlImg(),
            $perso->getId(),
        ];

        $stmt = $this->execRequest($sql, $params);
        return $stmt->rowCount();
    }
}
