<?php

namespace Models;

class User
{
    private ?string $id = null;
    private string $username;
    private string $hashPwd;

    /**
     * Hydrate l'objet User à partir d'un tableau associatif
     * issu d'une requête SQL.
     *
     * @param array<string,mixed> $row
     */
    public function hydrate(array $row): void
    {
        if (isset($row['id'])) {
            $this->id = $row['id'];
        }

        if (isset($row['username'])) {
            $this->username = $row['username'];
        }

        // On a fait un alias hash_pwd AS hashPwd en SQL
        if (isset($row['hashPwd'])) {
            $this->hashPwd = $row['hashPwd'];
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getHashPwd(): string
    {
        return $this->hashPwd;
    }

    public function setHashPwd(string $hashPwd): void
    {
        $this->hashPwd = $hashPwd;
    }
}
