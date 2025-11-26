<?php

namespace Services;

use Models\UserDAO;

class AuthService
{
    /**
     * Tente de connecter l'utilisateur.
     *
     * @param mixed $username
     * @param mixed $password
     */
    public static function login($username, $password): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = is_string($username) ? trim($username) : '';
        $password = is_string($password) ? $password : '';

        $dao  = new UserDAO();
        $user = $dao->getByUsername($username);

        // reset état auth
        unset($_SESSION['userUID'], $_SESSION['auth_timeout'], $_SESSION['auth_error']);

        if ($user === null) {
            $_SESSION['auth_error'] = 'Identifiants incorrects.';
            return;
        }

        if (!password_verify($password, $user->getHashPwd())) {
            $_SESSION['auth_error'] = 'Identifiants incorrects.';
            return;
        }

        // OK → on enregistre la connexion
        $_SESSION['userUID']      = $user->getId();
        // Connexion valable 1h (à adapter si tu veux)
        $_SESSION['auth_timeout'] = time() + 3600;
    }

    /**
     * Vérifie si l'utilisateur est connecté et non expiré.
     */
    public static function isAuthenticated(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (
            !isset($_SESSION['userUID'], $_SESSION['auth_timeout']) ||
            !is_string($_SESSION['userUID'])
        ) {
            return false;
        }

        // Timeout expiré → on déconnecte
        if ($_SESSION['auth_timeout'] < time()) {
            self::logout();
            return false;
        }

        return true;
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public static function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['userUID'], $_SESSION['auth_timeout'], $_SESSION['auth_error']);
    }
}
