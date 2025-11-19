<?php
$this->layout('template', ['title' => 'Ajouter un élément']);

$elements = ['Pyro', 'Hydro', 'Cryo', 'Electro', 'Anemo', 'Geo', 'Dendro'];
?>

<h1 class="h3 mb-4">Ajouter un élément</h1>

<section class="row">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">

                <form action="index.php?action=add-perso-element" method="post">

                    <!-- Nom -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l’élément</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                        <div class="form-text">Ex : Pyro, Cryo, Hydro…</div>
                    </div>

                    <!-- Image (URL) -->
                    <div class="mb-3">
                        <label for="urlImg" class="form-label">URL de l’icône</label>
                        <input type="url" id="urlImg" name="urlImg" class="form-control" placeholder="https://..." required>
                    </div>

                    <!-- Type d'élément -->
                    <div class="mb-3">
                        <label for="elementType" class="form-label">Type d’élément</label>
                        <select id="elementType" name="elementType" class="form-select">
                            <?php foreach ($elements as $el): ?>
                                <option value="<?= $this->e($el) ?>"><?= $this->e($el) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Enregistrer l’élément
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
