<?php
/** @var string|null $message éventuel message d'erreur/succès */
/** @var \Models\Personnage|null $personnage */

$isEdit    = isset($personnage);
$pageTitle = $isEdit ? 'Modifier un personnage' : 'Ajouter un personnage';

// Titre de la page pour le template
$this->layout('template', ['title' => $pageTitle]);
?>

<div class="container my-4">
    <h1 class="mb-4"><?= $this->e($pageTitle) ?></h1>

    <?php if (!empty($message)): ?>
        <div class="alert alert-warning">
            <?= $this->e($message) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <!-- action : add-perso en création / edit-perso en édition -->
            <form action="index.php?action=<?= $isEdit ? 'edit-perso' : 'add-perso' ?>" method="post">

                <?php if ($isEdit): ?>
                    <!-- Champ caché pour l'id du personnage -->
                    <input type="hidden" name="perso-id" value="<?= $this->e($personnage->getId()) ?>">
                <?php endif; ?>

                <!-- Nom du personnage -->
                <div class="mb-3">
                    <label for="perso-nom" class="form-label">Nom du personnage</label>
                    <input
                            type="text"
                            class="form-control"
                            id="perso-nom"
                            name="perso-nom"
                            value="<?= $isEdit ? $this->e($personnage->getName()) : '' ?>"
                            required
                    >
                </div>

                <!-- Élément (Pyro, Hydro, etc.) -->
                <div class="mb-3">
                    <label for="perso-element" class="form-label">Élément</label>
                    <input
                            type="text"
                            class="form-control"
                            id="perso-element"
                            name="perso-element"
                            placeholder="Pyro, Hydro, Cryo..."
                            value="<?= $isEdit ? $this->e($personnage->getElement()) : '' ?>"
                            required
                    >
                </div>

                <!-- Classe / arme / unitclass -->
                <div class="mb-3">
                    <label for="perso-unitclass" class="form-label">Classe / Arme</label>
                    <input
                            type="text"
                            class="form-control"
                            id="perso-unitclass"
                            name="perso-unitclass"
                            placeholder="Épée, Arc, Catalyseur..."
                            value="<?= $isEdit ? $this->e($personnage->getUnitclass()) : '' ?>"
                            required
                    >
                </div>

                <!-- Origine (région, ville...) -->
                <div class="mb-3">
                    <label for="perso-origin" class="form-label">Origine</label>
                    <input
                            type="text"
                            class="form-control"
                            id="perso-origin"
                            name="perso-origin"
                            placeholder="Mondstadt, Liyue, Inazuma..."
                            value="<?= $isEdit ? $this->e($personnage->getOrigin() ?? '') : '' ?>"
                    >
                </div>

                <!-- Rareté (1 à 5) -->
                <div class="mb-3">
                    <label for="perso-rarity" class="form-label">Rareté</label>
                    <input
                            type="number"
                            class="form-control"
                            id="perso-rarity"
                            name="perso-rarity"
                            min="1"
                            max="5"
                            value="<?= $isEdit ? $this->e($personnage->getRarity()) : '' ?>"
                            required
                    >
                </div>

                <!-- URL de l'image -->
                <div class="mb-3">
                    <label for="perso-url-img" class="form-label">URL de l'image</label>
                    <input
                            type="url"
                            class="form-control"
                            id="perso-url-img"
                            name="perso-url-img"
                            placeholder="https://..."
                            value="<?= $isEdit ? $this->e($personnage->getUrlImg()) : '' ?>"
                            required
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? 'Mettre à jour le personnage' : 'Créer le personnage' ?>
                </button>
            </form>
        </div>
    </div>
</div>
