<?php
namespace Controllers;

use League\Plates\Engine;
use Models\Personnage;
use Models\PersonnageDAO;

final class PersoController
{
    private Engine $templates;

    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }


    public function displayAddPerso(?string $message = null): void
    {
        echo $this->templates->render('add-perso', [
            'title'   => 'Ajouter un personnage',
            'message' => $message,
        ]);
    }

    public function addPerso(array $data): void
    {
        $data['id'] = uniqid('perso_', true);

        $perso = new Personnage();
        $perso->hydrate($data);

        $dao = new PersonnageDAO();

        try {
            $dao->createPersonnage($perso);

            $message = 'Le personnage "' . $perso->getName() . '" a bien été créé.';

        } catch (\Throwable $e) {
            $message = 'Erreur lors de la création du personnage : ' . $e->getMessage();
        }

        header('Location: index.php?message=' . urlencode($message));
        exit;
    }

    public function displayAddElement(): void
    {
        echo $this->templates->render('add-element', [
            'title' => 'Ajouter un élément (perso)'
        ]);
    }
}
