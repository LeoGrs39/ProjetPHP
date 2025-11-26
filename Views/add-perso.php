<?php
/** @var string|null $message éventuel message d'erreur/succès */
/** @var \Models\Personnage|null $personnage */
/** @var \Models\Element[] $elements */
/** @var \Models\UnitClass[] $unitclasses */
/** @var \Models\Origin[] $origins */

$isEdit    = isset($personnage);
$pageTitle = $isEdit ? 'Modifier un personnage' : 'Ajouter un personnage';

$this->layout('template', ['title' => $pageTitle]);

$selectedElementId   = null;
$selectedUnitClassId = null;
$selectedOriginId    = null;

if ($isEdit && $personnage !== null) {
    $el = $personnage->getElement();
    if ($el instanceof \Models\Element) {
        $selectedElementId = $el->getId();
    } else {
        $selectedElementId = (int)$el;
    }

    $uc = $personnage->getUnitclass();
    if ($uc instanceof \Models\UnitClass) {
        $selectedUnitClassId = $uc->getId();
    } else {
        $selectedUnitClassId = (int)$uc;
    }

    $or = $personnage->getOrigin();
    if ($or instanceof \Models\Origin) {
        $selectedOriginId = $or->getId();
    } elseif ($or !== null) {
        $selectedOriginId = (int)$or;
    }
}
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
            <form action="index.php?action=<?= $isEdit ? 'edit-perso' : 'add-perso' ?>" method="post">

                <?php if ($isEdit): ?>
                    <input type="hidden" name="perso-id" value="<?= $this->e($personnage->getId()) ?>">
                <?php endif; ?>

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

                <!-- Élément -->
                <div class="mb-3">
                    <label for="perso-element" class="form-label">Élément</label>
                    <select
                            class="form-select"
                            id="perso-element"
                            name="perso-element"
                            required
                    >
                        <option value="" disabled <?= $selectedElementId === null ? 'selected' : '' ?>>
                            Choisir un élément
                        </option>
                        <?php foreach ($elements as $el): ?>
                            <option
                                    value="<?= $this->e($el->getId()) ?>"
                                    <?= ($selectedElementId !== null && $selectedElementId == $el->getId()) ? 'selected' : '' ?>
                            >
                                <?= $this->e($el->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Classe / unitclass -->
                <div class="mb-3">
                    <label for="perso-unitclass" class="form-label">Classe / Arme</label>
                    <select
                            class="form-select"
                            id="perso-unitclass"
                            name="perso-unitclass"
                            required
                    >
                        <option value="" disabled <?= $selectedUnitClassId === null ? 'selected' : '' ?>>
                            Choisir une classe
                        </option>
                        <?php foreach ($unitclasses as $uc): ?>
                            <option
                                    value="<?= $this->e($uc->getId()) ?>"
                                    <?= ($selectedUnitClassId !== null && $selectedUnitClassId == $uc->getId()) ? 'selected' : '' ?>
                            >
                                <?= $this->e($uc->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Origine -->
                <div class="mb-3">
                    <label for="perso-origin" class="form-label">Origine</label>
                    <select
                            class="form-select"
                            id="perso-origin"
                            name="perso-origin"
                    >
                        <option value="" <?= $selectedOriginId === null ? 'selected' : '' ?>>
                            Aucune
                        </option>
                        <?php foreach ($origins as $or): ?>
                            <option
                                    value="<?= $this->e($or->getId()) ?>"
                                    <?= ($selectedOriginId !== null && $selectedOriginId == $or->getId()) ? 'selected' : '' ?>
                            >
                                <?= $this->e($or->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

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
