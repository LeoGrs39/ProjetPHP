<?php

namespace Services;

use Models\Personnage;
use Models\PersonnageDAO;
use Models\ElementDAO;
use Models\OriginDAO;
use Models\UnitClassDAO;

class PersonnageService
{
    private PersonnageDAO $persoDao;
    private ElementDAO $elementDao;
    private OriginDAO $originDao;
    private UnitClassDAO $unitClassDao;

    public function __construct()
    {
        $this->persoDao     = new PersonnageDAO();
        $this->elementDao   = new ElementDAO();
        $this->originDao    = new OriginDAO();
        $this->unitClassDao = new UnitClassDAO();
    }

    /**
     * Retourne une liste de Personnage COMPLETS (avec objets Element/Origin/UnitClass)
     *
     * @return Personnage[]
     */
    public function getAllPerso(): array
    {
        $rows = $this->persoDao->getAll();

        $result = [];

        foreach ($rows as $row) {
            $perso = new Personnage();

            $perso->setId($row['id']);
            $perso->setName($row['name']);
            $perso->setRarity((int)$row['rarity']);
            $perso->setUrlImg($row['urlImg']);

            $element   = $this->elementDao->getById((int)$row['element']);
            $unitClass = $this->unitClassDao->getById((int)$row['unitclass']);
            $origin    = null;

            if (!empty($row['origin'])) {
                $origin = $this->originDao->getById((int)$row['origin']);
            }

            $perso->setElement($element);
            $perso->setUnitclass($unitClass);
            $perso->setOrigin($origin);

            $result[] = $perso;
        }

        return $result;
    }

    public function createFromForm(array $data): Personnage
    {
        $id = uniqid('perso_', true);

        $name   = $data['name']        ?? $data['perso-nom']       ?? '';
        $rarity = (int)($data['rarity'] ?? $data['perso-rarity']   ?? 0);
        $urlImg = $data['urlImg']      ?? $data['url_img']        ?? $data['perso-url-img'] ?? '';

        $elId = (int)($data['element']   ?? $data['perso-element']   ?? 0);
        $ucId = (int)($data['unitclass'] ?? $data['perso-unitclass'] ?? 0);

        $originRaw = $data['origin'] ?? $data['perso-origin'] ?? null;
        $originId  = ($originRaw === '' || $originRaw === null) ? null : (int)$originRaw;

        $element   = $this->elementDao->getById($elId);
        $unitClass = $this->unitClassDao->getById($ucId);
        $origin    = $originId !== null ? $this->originDao->getById($originId) : null;

        if (!$element || !$unitClass) {
            throw new \RuntimeException("Élément ou classe d'unité introuvable.");
        }

        $perso = new Personnage();
        $perso->setId($id);
        $perso->setName($name);
        $perso->setRarity($rarity);
        $perso->setUrlImg($urlImg);
        $perso->setElement($element);
        $perso->setUnitclass($unitClass);
        $perso->setOrigin($origin);

        $this->persoDao->createPersonnage($perso);

        return $perso;
    }

    /**
     * Update un personnage à partir du formulaire (Partie 5 – 2.3).
     */
    public function updateFromForm(array $data): Personnage
    {
        $id = $data['id'] ?? $data['perso-id'] ?? null;
        if ($id === null || $id === '') {
            throw new \RuntimeException("Identifiant du personnage manquant pour la mise à jour.");
        }

        $name   = $data['name']        ?? $data['perso-nom']       ?? '';
        $rarity = (int)($data['rarity'] ?? $data['perso-rarity']   ?? 0);
        $urlImg = $data['urlImg']      ?? $data['url_img']        ?? $data['perso-url-img'] ?? '';

        $elId = (int)($data['element']   ?? $data['perso-element']   ?? 0);
        $ucId = (int)($data['unitclass'] ?? $data['perso-unitclass'] ?? 0);

        $originRaw = $data['origin'] ?? $data['perso-origin'] ?? null;
        $originId  = ($originRaw === '' || $originRaw === null) ? null : (int)$originRaw;

        $element   = $this->elementDao->getById($elId);
        $unitClass = $this->unitClassDao->getById($ucId);
        $origin    = $originId !== null ? $this->originDao->getById($originId) : null;

        if (!$element || !$unitClass) {
            throw new \RuntimeException("Élément ou classe d'unité introuvable.");
        }

        $perso = new Personnage();
        $perso->setId($id);
        $perso->setName($name);
        $perso->setRarity($rarity);
        $perso->setUrlImg($urlImg);
        $perso->setElement($element);
        $perso->setUnitclass($unitClass);
        $perso->setOrigin($origin);

        $this->persoDao->updatePersonnage($perso);

        return $perso;
    }
}
