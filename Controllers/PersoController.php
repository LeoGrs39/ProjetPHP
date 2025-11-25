<?php
namespace Controllers;

use League\Plates\Engine;
use Models\Personnage;
use Models\PersonnageDAO;
use Helper\Message;

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
            'message' => $message,
            // pas de personnage -> mode création
            'personnage' => null,
        ]);
    }


    public function displayEditPerso(string $idPerso, ?string $message = null): void
    {
        $dao      = new PersonnageDAO();
        $perso    = $dao->getByID($idPerso);

        if ($perso === null) {
            // Si l'id ne correspond à aucun perso en BD
            $this->displayAddPerso("Personnage introuvable pour l'id fourni.");
            return;
        }

        echo $this->templates->render('add-perso', [
            'message'    => $message,
            'personnage' => $perso,
        ]);
    }


    public function addPerso(array $data): void
    {
        // Ajout de l'id
        $data['id'] = uniqid('perso_', true);

        // Création de l'objet Personnage
        $perso = new Personnage();
        $perso->hydrate($data);

        $dao = new PersonnageDAO();

        try {
            $dao->createPersonnage($perso);
            $message = 'Le personnage "' . $perso->getName() . '" a bien été créé.';
        } catch (\Throwable $e) {
            $message = 'Erreur lors de la création du personnage : ' . $e->getMessage();
        }

        // Redirection vers l'index avec le message
        header('Location: index.php?message=' . urlencode($message));
        exit;
    }


    public function deletePersoAndIndex(?string $idPerso = null): void
    {
        $dao = new PersonnageDAO();

        if ($idPerso === null) {
            $message = "Impossible de supprimer : identifiant manquant.";
        } else {
            try {
                $rowCount = $dao->deletePerso($idPerso);

                if ($rowCount > 0) {
                    $message = "Suppression réussie du personnage.";
                } else {
                    $message = "Aucun personnage trouvé pour cet identifiant.";
                }
            } catch (\Throwable $e) {
                $message = "Erreur lors de la suppression : " . $e->getMessage();
            }
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

    public function editPersoAndIndex(array $data): void
    {
        $dao = new PersonnageDAO();

        $perso = new Personnage();
        $perso->hydrate($data);

        try {
            $rowCount = $dao->updatePersonnage($perso);

            if ($rowCount > 0) {
                $message = "Le personnage a bien été mis à jour.";
            } else {
                $message = "Aucune modification détectée ou personnage introuvable.";
            }
        } catch (\Throwable $e) {
            $message = "Erreur lors de l’update : " . $e->getMessage();
        }

        header('Location: index.php?message=' . urlencode($message));
        exit;
    }
}
