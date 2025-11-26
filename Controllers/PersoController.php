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
use Exceptions\PersonnageNotFoundException;
use Exceptions\AttributeCreationException;

/**
 * Class PersoController
 * * Contrôleur final gérant le CRUD des personnages (Ajout, Édition, Suppression)
 * ainsi que la création des attributs liés (Éléments, Origines, Classes).
 */
final class PersoController
{
    private Engine $templates;
    private LogService $logger;

    /**
     * Constructeur du contrôleur.
     *
     * @param Engine $templates Moteur de template (Plates)
     */
    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
        $this->logger    = new LogService();
    }

    /**
     * Affiche le formulaire d'ajout d'un personnage.
     * * Charge les listes (éléments, origines, classes) pour alimenter les listes déroulantes.
     *
     * @param string|null $message Message optionnel à afficher (ex: erreur ou info)
     * @return void
     */
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

    /**
     * Affiche le formulaire d'édition pour un personnage existant.
     * * Si l'ID ne correspond à rien, redirige vers le formulaire d'ajout avec une erreur.
     *
     * @param string $idPerso Identifiant unique du personnage
     * @param string|null $message Message optionnel
     * @return void
     */
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
     * Traite la soumission du formulaire de création de personnage.
     * * Valide les données via le Service, loggue le résultat et redirige vers l'index.
     *
     * @param array{
     * name: string,
     * element: int,
     * unitclass: int,
     * origin?: int|null,
     * rarity: int,
     * urlImg: string
     * } $data Données issues du formulaire ($_POST)
     * @return void
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

    /**
     * Supprime un personnage et redirige vers la page d'accueil.
     *
     * @param string|null $idPerso Identifiant du personnage à supprimer
     * @return void
     */
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

    /**
     * Traite la soumission du formulaire de modification de personnage.
     *
     * @param array $data Données issues du formulaire ($_POST) contenant l'ID du personnage
     * @return void
     */
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

        } catch (PersonnageNotFoundException $e) {

            $this->logger->log(
                'UPDATE_PERSO',
                'Personnage introuvable : '.$e->getMessage(),
                false
            );

            $msgObj = new Message(
                "Personnage introuvable : " . $e->getMessage(),
                Message::COLOR_ERROR,
                "Personnage introuvable"
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

    /**
     * Affiche le formulaire d'ajout d'un attribut (Element, Origine ou Classe).
     *
     * @param string|null $message Message optionnel
     * @return void
     */
    public function displayAddElement(?string $message = null): void
    {
        echo $this->templates->render('add-element', [
            'title'   => 'Ajouter un attribut',
            'message' => $message,
        ]);
    }

    /**
     * Traite l'ajout d'un attribut (Element, Origin, UnitClass) depuis le formulaire.
     * * Instancie le bon modèle et le bon DAO en fonction du type reçu.
     *
     * @param array $data Données du formulaire (type, name, url_img)
     * @return void
     */
    public function addAttributeFromForm(array $data): void
    {
        $type   = $data['type']    ?? null;
        $name   = isset($data['name']) ? trim($data['name']) : '';
        $urlImg = isset($data['url_img']) ? trim($data['url_img']) : '';

        try {
            if (!$type || $name === '' || $urlImg === '') {
                throw new AttributeCreationException("Tous les champs sont obligatoires.");
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
                    throw new AttributeCreationException("Type d'attribut inconnu : $type");
            }

            $attr->setName($name);
            $attr->setUrlImg($urlImg);

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

                header('Location: index.php?message=' . urlencode(serialize($msgObj)));
                exit;

            } else {
                throw new AttributeCreationException(
                    "Impossible de créer l'attribut (aucune ligne modifiée)."
                );
            }

        } catch (AttributeCreationException $e) {

            $this->logger->log(
                'CREATE_ATTR',
                "Erreur métier création attribut '$type' ($name) : ".$e->getMessage(),
                false
            );

            // On reste sur la page du formulaire avec le message d'erreur
            $this->displayAddElement($e->getMessage());
            return;

        } catch (\Throwable $e) {

            $this->logger->log(
                'CREATE_ATTR',
                "Erreur technique lors de la création d'attribut '$type' ($name) : ".$e->getMessage(),
                false
            );

            $msgObj = new Message(
                "Erreur lors de la création de l'attribut : " . $e->getMessage(),
                Message::COLOR_ERROR,
                "Erreur"
            );

            header('Location: index.php?message=' . urlencode(serialize($msgObj)));
            exit;
        }
    }
}