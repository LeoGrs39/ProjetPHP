<?php
namespace Controllers;

use League\Plates\Engine;

class MainController
{
    /**
     * 🔹 Attribut de la classe
     * Il sert à stocker l'instance du moteur de templates Plates (Engine)
     */
    private Engine $templates;

    /**
     * 🔹 Constructeur
     * Initialise l'attribut $templates avec le dossier des vues
     */
    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    /**
     * 🔹 Méthode d'affichage de la page d'accueil
     * (Question 4.2 : construire la vue)
     */
    public function index(): void
    {
        echo $this->templates->render('home', [
            'gameName' => 'Genshin Impact'
        ]);
    }
}
