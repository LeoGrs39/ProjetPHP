<?php $this->layout('template', ['title' => 'Ajouter un attribut']) ?>

<h1>Ajouter un élément / origine / classe</h1>

<form method="post" action="index.php?action=add-perso-element">
    <div class="mb-3">
        <label for="type" class="form-label">Type d'attribut</label>
        <select name="type" id="type" class="form-select" required>
            <option value="element">Élément</option>
            <option value="origin">Origine</option>
            <option value="unitclass">Classe d'unité</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="mb-3">
        <label for="url_img" class="form-label">URL de l'image</label>
        <input type="text" class="form-control" id="url_img" name="url_img" required>
    </div>

    <button type="submit" class="btn btn-primary">Créer l'attribut</button>
</form>