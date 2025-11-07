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
}
