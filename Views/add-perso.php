<?php
$this->layout('template', ['title' => 'Ajouter un personnage']);

// Petites listes pour les <select>
$elements = ['Pyro', 'Hydro', 'Cryo', 'Electro', 'Anemo', 'Geo', 'Dendro'];
$weapons  = ['Sword', 'Claymore', 'Polearm', 'Bow', 'Catalyst'];
$origins  = ['Mondstadt', 'Liyue', 'Inazuma', 'Sumeru', 'Fontaine', 'Natlan', 'Snezhnaya'];
?>

<h1 class="h3 mb-4">Ajouter un personnage</h1>

<section class="row">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="index.php?action=add-perso" method="post">

                    <!-- Nom -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom du personnage</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="form-text">Ex : Charlotte, Hu Tao, etc.</div>
                    </div>

                    <!-- URL image -->
                    <div class="mb-3">
                        <label for="urlImg" class="form-label">URL de l'image</label>
                        <input type="url" class="form-control" id="urlImg" name="urlImg" placeholder="https://...">
                        <div class="form-text">Lien vers une image officielle du personnage.</div>
                    </div>

                    <!-- Rareté -->
                    <div class="mb-3">
                        <label for="rarity" class="form-label">Rareté</label>
                        <select class="form-select" id="rarity" name="rarity">
                            <option value="4">★★★★ (4★)</option>
                            <option value="5">★★★★★ (5★)</option>
                        </select>
                    </div>

                    <!-- Élément + Arme -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="element" class="form-label">Élément</label>
                            <select class="form-select" id="element" name="element">
                                <?php foreach ($elements as $el): ?>
                                    <option value="<?= $this->e($el) ?>"><?= $this->e($el) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="unitclass" class="form-label">Type d’arme</label>
                            <select class="form-select" id="unitclass" name="unitclass">
                                <?php foreach ($weapons as $w): ?>
                                    <option value="<?= $this->e($w) ?>"><?= $this->e($w) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Origine -->
                    <div class="mb-3">
                        <label for="origin" class="form-label">Origine</label>
                        <select class="form-select" id="origin" name="origin">
                            <option value="">(Autre / non spécifié)</option>
                            <?php foreach ($origins as $o): ?>
                                <option value="<?= $this->e($o) ?>"><?= $this->e($o) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Enregistrer le personnage
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
