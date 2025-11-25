<?php
namespace Controllers;

use League\Plates\Engine;
use Models\Personnage;
use Models\PersonnageDAO;
use Models\Element;
use Models\ElementDAO;
use Models\Origin;
use Models\OriginDAO;
use Models\UnitClass;
use Models\UnitClassDAO;
use Helpers\Message;
use Services\PersonnageService;
use Services\LogService;

final class PersoController
{
    private Engine $templates;
    private LogService $logger;

    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
        $this->logger    = new LogService();
    }

    public function displayAddPerso(?string $message = null): void
    {
        $elementDao   = new ElementDAO();
        $originDao    = new OriginDAO();
        $unitClassDao = new UnitClassDAO();

        $elements    = $elementDao->getAll();
        $origins     = $originDao->getAll();
        $unitclasses = $unitClassDao->getAll();

        echo $this->templates->render('add-perso', [
            'message'     => $message,
            'personnage'  => null,
            'elements'    => $elements,
            'origins'     => $origins,
            'unitclasses' => $unitclasses,
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

        $elementDao   = new ElementDAO();
        $originDao    = new OriginDAO();
        $unitClassDao = new UnitClassDAO();

        $elements    = $elementDao->getAll();
        $origins     = $originDao->getAll();
        $unitclasses = $unitClassDao->getAll();

        echo $this->templates->render('add-perso', [
            'message'     => $message,
            'personnage'  => $perso,
            'elements'    => $elements,
            'origins'     => $origins,
            'unitclasses' => $unitclasses,
        ]);
    }

    /**
     * @param array{
     *   name: string,
     *   element: int,
     *   unitclass: int,
     *   origin?: int|null,
     *   rarity: int,
     *   urlImg: string
     * } $data
     */
    public function addPerso(array $data): void
    {
        $service = new PersonnageService();

        try {
            $perso = $service->createFromForm($data);

            $this->logger->log(
                'CREATE_PERSO',
                'Création du personnage '.$perso->getId().' ('.$perso->getName().')',
                true
            );

            $msgObj = new Message(
                'Le personnage "' . $perso->getName() . '" a bien été créé.',
                Message::COLOR_SUCCESS,
                'Création réussie'
            );
        } catch (\Throwable $e) {
            $this->logger->log(
                'CREATE_PERSO',
                'Erreur lors de la création du personnage : '.$e->getMessage(),
                false
            );

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

            $this->logger->log(
                'DELETE_PERSO',
                "Échec suppression : identifiant manquant",
                false
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

                    $this->logger->log(
                        'DELETE_PERSO',
                        "Suppression du personnage $idPerso",
                        true
                    );
                } else {
                    $msgObj = new Message(
                        "Aucun personnage trouvé pour cet identifiant.",
                        Message::COLOR_INFO,
                        "Information"
                    );

                    $this->logger->log(
                        'DELETE_PERSO',
                        "Aucun personnage trouvé pour l'id $idPerso",
                        false
                    );
                }
            } catch (\Throwable $e) {
                $msgObj = new Message(
                    "Erreur lors de la suppression : " . $e->getMessage(),
                    Message::COLOR_ERROR,
                    "Erreur de suppression"
                );

                $this->logger->log(
                    'DELETE_PERSO',
                    "Erreur lors de la suppression de $idPerso : ".$e->getMessage(),
                    false
                );
            }
        }

        header('Location: index.php?message=' . urlencode(serialize($msgObj)));
        exit;
    }

    public function editPersoAndIndex(array $data): void
    {
        $service = new PersonnageService();

        try {
            $perso  = $service->updateFromForm($data);

            $this->logger->log(
                'UPDATE_PERSO',
                'Mise à jour du personnage '.$perso->getId().' ('.$perso->getName().')',
                true
            );

            $msgObj = new Message(
                "Le personnage a bien été mis à jour.",
                Message::COLOR_SUCCESS,
                "Mise à jour réussie"
            );
        } catch (\Throwable $e) {
            $this->logger->log(
                'UPDATE_PERSO',
                'Erreur lors de la mise à jour du personnage : '.$e->getMessage(),
                false
            );

            $msgObj = new Message(
                "Erreur lors de la mise à jour : " . $e->getMessage(),
                Message::COLOR_ERROR,
                "Erreur de mise à jour"
            );
        }

        header('Location: index.php?message=' . urlencode(serialize($msgObj)));
        exit;
    }

    public function displayAddElement(?string $message = null): void
    {
        echo $this->templates->render('add-element', [
            'title'   => 'Ajouter un attribut',
            'message' => $message,
        ]);
    }

    public function addAttributeFromForm(array $data): void
    {
        $type   = $data['type']    ?? null;
        $name   = isset($data['name']) ? trim($data['name']) : '';
        $urlImg = isset($data['url_img']) ? trim($data['url_img']) : '';

        if (!$type || $name === '' || $urlImg === '') {
            $this->logger->log(
                'CREATE_ATTR',
                "Échec création attribut (champ manquant)",
                false
            );

            $this->displayAddElement("Tous les champs sont obligatoires.");
            return;
        }

        switch ($type) {
            case 'element':
                $attr = new Element();
                $dao  = new ElementDAO();
                break;

            case 'origin':
                $attr = new Origin();
                $dao  = new OriginDAO();
                break;

            case 'unitclass':
                $attr = new UnitClass();
                $dao  = new UnitClassDAO();
                break;

            default:
                $this->logger->log(
                    'CREATE_ATTR',
                    "Type d'attribut inconnu : $type",
                    false
                );

                $this->displayAddElement("Type d'attribut inconnu.");
                return;
        }

        $attr->setName($name);
        $attr->setUrlImg($urlImg);

        try {
            $ok = $dao->create($attr);

            if ($ok) {
                $this->logger->log(
                    'CREATE_ATTR',
                    "Création attribut '$type' ($name)",
                    true
                );

                $msgObj = new Message(
                    "L'attribut a bien été créé.",
                    Message::COLOR_SUCCESS,
                    "Création réussie"
                );
            } else {
                $this->logger->log(
                    'CREATE_ATTR',
                    "Aucune ligne modifiée lors de la création d'attribut '$type' ($name)",
                    false
                );

                $msgObj = new Message(
                    "Impossible de créer l'attribut (aucune ligne modifiée).",
                    Message::COLOR_ERROR,
                    "Erreur"
                );
            }
        } catch (\Throwable $e) {
            $this->logger->log(
                'CREATE_ATTR',
                "Erreur lors de la création d'attribut '$type' ($name) : ".$e->getMessage(),
                false
            );

            $msgObj = new Message(
                "Erreur lors de la création de l'attribut : " . $e->getMessage(),
                Message::COLOR_ERROR,
                "Erreur"
            );
        }

        header('Location: index.php?message=' . urlencode(serialize($msgObj)));
        exit;
    }
}
