<?php
/** @var string|null $message éventuel message d'erreur/succès (utilisé plus tard dans la partie 4) */
$this->layout('template', ['title' => 'Ajouter un personnage']);
?>

<div class="container my-4">
    <h1 class="mb-4">Ajouter un personnage</h1>

    <?php if (!empty($message)): ?>
        <div class="alert alert-warning">
            <?= $this->e($message) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <!-- IMPORTANT : méthode POST + action vers add-perso -->
            <form action="index.php?action=add-perso" method="post">
                <!-- Nom du personnage -->
                <div class="mb-3">
                    <label for="perso-nom" class="form-label">Nom du personnage</label>
                    <input
                            type="text"
                            class="form-control"
                            id="perso-nom"
                            name="perso-nom"
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
                            required
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    Créer le personnage
                </button>
            </form>
        </div>
    </div>
</div>
