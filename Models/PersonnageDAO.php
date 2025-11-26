<?php
namespace Models;

/**
 * Class PersonnageDAO
 * * DAO responsable de la gestion de la table PERSONNAGE en base de données.
 * Permet de récupérer, créer, modifier et supprimer des personnages.
 */
class PersonnageDAO extends BasePDODAO
{
    /**
     * Récupère la liste brute de tous les personnages.
     *
     * @return array<int,array<string,mixed>> Tableau de tableaux associatifs représentant les lignes de la table.
     */
    public function getAll(): array
    {
        $sql  = "SELECT id, name, element, unitclass, origin, rarity, url_img AS urlImg
                 FROM PERSONNAGE";
        return $this->execRequest($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Recherche un personnage par son identifiant unique.
     *
     * @param string $idPersonnage L'identifiant du personnage
     * @return Personnage|null L'objet Personnage hydraté ou null si introuvable
     */
    public function getByID(string $idPersonnage): ?Personnage
    {
        $sql  = "SELECT id, name, element, unitclass, origin, rarity, url_img AS urlImg
                 FROM PERSONNAGE WHERE id = ?";
        $stmt = $this->execRequest($sql, [$idPersonnage]);
        $row  = $stmt->fetch();
        return $row ? $this->mapRowToEntity($row) : null;
    }

    /**
     * Insère un nouveau personnage en base de données.
     * * Extrait les identifiants des objets liés (Element, UnitClass, Origin) pour gérer les clés étrangères.
     *
     * @param Personnage $personnage L'objet personnage à persister
     * @return void
     */
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

    /**
     * Supprime un personnage de la base de données via son ID.
     *
     * @param string|null $idPerso L'identifiant du personnage (ne fait rien si null)
     * @return int Le nombre de lignes supprimées (devrait être 1 si succès, 0 sinon)
     */
    public function deletePerso(?string $idPerso = null): int
    {
        if ($idPerso === null) {
            return 0;
        }

        $sql  = "DELETE FROM PERSONNAGE WHERE id = ?";
        $stmt = $this->execRequest($sql, [$idPerso]);

        return $stmt->rowCount();
    }

    /**
     * Convertit une ligne de résultat SQL (tableau associatif) en objet Personnage.
     *
     * @param array $row Données brutes issues de la BDD
     * @return Personnage L'objet hydraté
     */
    private function mapRowToEntity(array $row): Personnage
    {
        $p = new Personnage();
        $p->hydrate($row);
        return $p;
    }

    /**
     * Met à jour les informations d'un personnage existant.
     *
     * @param Personnage $perso L'objet contenant les nouvelles données
     * @return int Le nombre de lignes affectées par la mise à jour
     */
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