<?php

namespace Models;

class Element
{
    private ?int $id = null;
    private string $name;
    private string $urlImg;

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getUrlImg(): string { return $this->urlImg; }

    public function setId(?int $id): void { $this->id = $id; }
    public function setName(string $name): void { $this->name = $name; }
    public function setUrlImg(string $urlImg): void { $this->urlImg = $urlImg; }

    public function hydrate(array $data): void
    {
        if (isset($data['id']))      { $this->setId((int)$data['id']); }
        if (isset($data['name']))    { $this->setName($data['name']); }
        if (isset($data['url_img'])) { $this->setUrlImg($data['url_img']); }
    }
}