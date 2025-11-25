<?php

namespace Models;

class Personnage
{
    private ?string $id = null;
    private string $name;

    /** @var Element|int */
    private $element;

    /** @var UnitClass|int */
    private $unitclass;

    /** @var Origin|int|null */
    private $origin;

    private int $rarity;
    private string $urlImg;

    public function hydrate(array $row): void
    {
        if (isset($row['id'])) {
            $this->id = $row['id'];
        }

        if (isset($row['name'])) {
            $this->name = $row['name'];
        }

        if (isset($row['element'])) {
            // On stocke d’abord l’ID → le Service remplacera par l'objet correspondant
            $this->element = $row['element']; // int
        }

        if (isset($row['unitclass'])) {
            $this->unitclass = $row['unitclass']; // int
        }

        if (array_key_exists('origin', $row)) {
            $this->origin = $row['origin'] ?? null; // int|null
        }

        if (isset($row['rarity'])) {
            $this->rarity = (int)$row['rarity'];
        }

        if (isset($row['urlImg'])) {
            $this->urlImg = $row['urlImg'];
        }
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Element|int
     */
    public function getElement()
    {
        return $this->element;
    }

    public function setElement(Element $element): void
    {
        $this->element = $element;
    }

    /**
     * @return UnitClass|int
     */
    public function getUnitclass()
    {
        return $this->unitclass;
    }

    public function setUnitclass(UnitClass $unitclass): void
    {
        $this->unitclass = $unitclass;
    }

    /**
     * @return Origin|int|null
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    public function setOrigin(?Origin $origin): void
    {
        $this->origin = $origin;
    }

    public function getRarity(): int
    {
        return $this->rarity;
    }

    public function setRarity(int $rarity): void
    {
        $this->rarity = $rarity;
    }

    public function getUrlImg(): string
    {
        return $this->urlImg;
    }

    public function setUrlImg(string $urlImg): void
    {
        $this->urlImg = $urlImg;
    }
}
