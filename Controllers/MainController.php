<?php
namespace Controllers;

use League\Plates\Engine;
use Models\PersonnageDAO;

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
        $dao = new PersonnageDAO();

        // 1) Tous les personnages (array<Personnage>)
        $listPersonnage = $dao->getAll();

        // 2) Un ID qui existe : on prend l'id du premier si dispo (sinon null)
        $first = null;
        $existing = null;
        if (!empty($listPersonnage)) {
            $first = $listPersonnage[0];              // objet Personnage
            $existing = $dao->getByID($first->getId()); // objet Personnage
        }

        // 3) Un ID qui n’existe pas -> doit retourner null
        $other = $dao->getByID('does-not-exist-123');

        // Passe les 3 variables à la vue (cf. consigne 2.3)
        echo $this->templates->render('home', [
            'gameName'       => 'Genshin Impact',
            'listPersonnage' => $listPersonnage,
            'first'          => $existing,
            'other'          => $other,
        ]);
    }
}
