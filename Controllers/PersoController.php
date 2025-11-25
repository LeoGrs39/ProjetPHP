<?php
namespace Controllers;

use League\Plates\Engine;
use Models\Personnage;
use Models\PersonnageDAO;
use Helpers\Message;

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
            'message'    => $message,
            'personnage' => null,
        ]);
    }


    public function displayEditPerso(string $idPerso, ?string $message = null): void
    {
        $dao   = new PersonnageDAO();
        $perso = $dao->getByID($idPerso);

        if ($perso === null) {
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
        $data['id'] = uniqid('perso_', true);

        $perso = new Personnage();
        $perso->hydrate($data);

        $dao = new PersonnageDAO();

        try {
            $dao->createPersonnage($perso);
            $msgObj = new Message(
                'Le personnage "' . $perso->getName() . '" a bien été créé.',
                Message::COLOR_SUCCESS,
                'Création réussie'
            );
        } catch (\Throwable $e) {
            $msgObj = new Message(
                'Erreur lors de la création du personnage : ' . $e->getMessage(),
                Message::COLOR_ERROR,
                'Erreur'
            );
        }

        header('Location: index.php?message=' . urlencode(serialize($msgObj)));
        exit;
    }


    public function deletePersoAndIndex(?string $idPerso = null): void
    {
        $dao = new PersonnageDAO();
        $msgObj = null;

        if ($idPerso === null) {
            $msgObj = new Message(
                "Impossible de supprimer : identifiant manquant.",
                Message::COLOR_ERROR,
                "Erreur de suppression"
            );
        } else {
            try {
                $rowCount = $dao->deletePerso($idPerso);

                if ($rowCount > 0) {
                    $msgObj = new Message(
                        "Suppression réussie du personnage.",
                        Message::COLOR_SUCCESS,
                        "Suppression réussie"
                    );
                } else {
                    $msgObj = new Message(
                        "Aucun personnage trouvé pour cet identifiant.",
                        Message::COLOR_INFO,
                        "Information"
                    );
                }
            } catch (\Throwable $e) {
                $msgObj = new Message(
                    "Erreur lors de la suppression : " . $e->getMessage(),
                    Message::COLOR_ERROR,
                    "Erreur de suppression"
                );
            }
        }

        header('Location: index.php?message=' . urlencode(serialize($msgObj)));
        exit;
    }


    public function displayAddElement(): void
    {
        echo $this->templates->render('add-element', [
            'title' => 'Ajouter un élément (perso)'
        ]);
    }

    /**
     * Update d'un personnage puis retour index avec message.
     */
    public function editPersoAndIndex(array $data): void
    {
        $dao   = new PersonnageDAO();
        $perso = new Personnage();
        $perso->hydrate($data);

        try {
            $rowCount = $dao->updatePersonnage($perso);

            if ($rowCount > 0) {
                $msgObj = new Message(
                    "Le personnage a bien été mis à jour.",
                    Message::COLOR_SUCCESS,
                    "Mise à jour réussie"
                );
            } else {
                $msgObj = new Message(
                    "Aucune modification détectée ou personnage introuvable.",
                    Message::COLOR_INFO,
                    "Information"
                );
            }
        } catch (\Throwable $e) {
            $msgObj = new Message(
                "Erreur lors de l’update : " . $e->getMessage(),
                Message::COLOR_ERROR,
                "Erreur de mise à jour"
            );
        }

        header('Location: index.php?message=' . urlencode(serialize($msgObj)));
        exit;
    }
}
