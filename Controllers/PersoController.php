<?php
namespace Controllers;

final class PersoController
{
    private \League\Plates\Engine $templates;

    public function __construct(\League\Plates\Engine $templates)
    {
        $this->templates = $templates;
    }

    public function displayAddPerso(): void
    {
        echo $this->templates->render('add-perso', [
            'title' => 'Ajouter un personnage'
        ]);
    }

    /**
     * Page d'ajout d'élément pour un perso : vue "add-element.php"
     */
    public function displayAddElement(): void
    {
        echo $this->templates->render('add-element', [
            'title' => 'Ajouter un élément (perso)'
        ]);
    }
}
