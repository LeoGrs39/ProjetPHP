<?php

namespace Controllers;

use League\Plates\Engine;
use Helpers\Message;
use Services\AuthService;

class AuthController
{
    private Engine $templates;

    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    /**
     * Affiche le formulaire de connexion.
     */
    public function showLoginForm(): void
    {
        if (\Services\AuthService::isAuthenticated()) {
            header('Location: index.php');
            exit;
        }

        $raw     = $_GET['message'] ?? null;
        $message = null;

        if ($raw !== null && $raw !== '') {
            $maybe = @unserialize($raw);
            if ($maybe instanceof \Helpers\Message) {
                $message = $maybe;
            } else {
                $message = new \Helpers\Message((string)$raw);
            }
        }

        echo $this->templates->render('login', [
            'message' => $message,
        ]);
    }

    /**
     * Traite le POST du formulaire de login.
     *
     * @param array<string,mixed> $post
     */
    public function handleLogin(array $post): void
    {
        $username = $post['username'] ?? '';
        $password = $post['password'] ?? '';

        AuthService::login($username, $password);

        if (AuthService::isAuthenticated()) {
            $msg   = 'Connexion réussie.';
            $query = http_build_query(['message' => $msg]);
            header('Location: index.php?' . $query);
            exit;
        }

        header('Location: index.php?action=login');
        exit;
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout(): void
    {
        AuthService::logout();

        $msg   = 'Déconnexion réussie.';
        $query = http_build_query(['message' => $msg]);
        header('Location: index.php?' . $query);
        exit;
    }

    /**
     * Affiche la page protégée.
     * (Pour l’instant l’accès sera géré plus tard par le routeur.)
     */
    public function showProtected(): void
    {
        echo $this->templates->render('protected', [
            'message' => null,
        ]);
    }
}
