<?php

namespace Models;

/**
 * Class UserDAO
 * DAO responsable de la gestion de la table USERS.
 */
class UserDAO extends BasePDODAO
{
    /**
     * Récupère un utilisateur par son username.
     *
     * @param string $username
     * @return User|null
     */
    public function getByUsername(string $username): ?User
    {
        $sql  = "SELECT id, username, hash_pwd AS hashPwd
                 FROM USERS
                 WHERE username = ?";

        $stmt = $this->execRequest($sql, [$username]);
        $row  = $stmt->fetch();

        return $row ? $this->mapRowToEntity($row) : null;
    }

    /**
     * (Optionnel mais pratique) Récupère un utilisateur par son ID.
     *
     * @param string $id
     * @return User|null
     */
    public function getById(string $id): ?User
    {
        $sql  = "SELECT id, username, hash_pwd AS hashPwd
                 FROM USERS
                 WHERE id = ?";

        $stmt = $this->execRequest($sql, [$id]);
        $row  = $stmt->fetch();

        return $row ? $this->mapRowToEntity($row) : null;
    }

    /**
     * Convertit une ligne SQL en objet User.
     *
     * @param array<string,mixed> $row
     * @return User
     */
    private function mapRowToEntity(array $row): User
    {
        $u = new User();
        $u->hydrate($row);
        return $u;
    }
}
