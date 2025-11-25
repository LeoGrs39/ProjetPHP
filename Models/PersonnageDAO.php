<?php
namespace Models;

class PersonnageDAO extends BasePDODAO
{
    /**
     * @return array<int,array<string,mixed>>
     */
    public function getAll(): array
    {
        $sql  = "SELECT id, name, element, unitclass, origin, rarity, url_img AS urlImg
                 FROM PERSONNAGE";
        return $this->execRequest($sql)->fetchAll(\PDO::FETCH_ASSOC);
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

        $elementId   = $personnage->getElement()?->getId();
        $unitclassId = $personnage->getUnitclass()?->getId();
        $originObj   = $personnage->getOrigin();
        $originId    = $originObj ? $originObj->getId() : null;

        $params = [
            $personnage->getId(),
            $personnage->getName(),
            $elementId,
            $unitclassId,
            $originId,
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

        $elementId   = $perso->getElement()?->getId();
        $unitclassId = $perso->getUnitclass()?->getId();
        $originObj   = $perso->getOrigin();
        $originId    = $originObj ? $originObj->getId() : null;

        $params = [
            $perso->getName(),
            $elementId,
            $unitclassId,
            $originId,
            $perso->getRarity(),
            $perso->getUrlImg(),
            $perso->getId(),
        ];

        $stmt = $this->execRequest($sql, $params);
        return $stmt->rowCount();
    }
}
