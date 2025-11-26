<?php $this->layout('template', ['title' => 'Collection Genshin Impact']) ?>

<?php
$stars = function(int $n): string {
    return str_repeat('★', max(0, min(5, $n)));
};
?>

<section class="mb-4">
    <h1 class="h3">Collection <?= $this->e($gameName) ?></h1>
    <p class="text-muted">Affichage de votre dream team</p>
</section>

<section class="mb-5">
    <?php if (empty($listPersonnage)): ?>
        <div class="alert alert-secondary">Aucun personnage pour le moment.</div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($listPersonnage as $p): ?>
                <?php
                $element   = $p->getElement();
                $origin    = $p->getOrigin();
                $unitclass = $p->getUnitclass();
                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm h-100">

                        <!-- Portrait du personnage -->
                        <div class="ratio ratio-portrait img-frame">
                            <img
                                    class="img-cover"
                                    src="<?= $this->e($p->getUrlImg()) ?>"
                                    alt="Portrait de <?= $this->e($p->getName()) ?>"
                                    loading="lazy"
                                    onerror="this.src='https://via.placeholder.com/600x800?text=No+Image'">
                        </div>

                        <div class="card-body d-flex flex-column">

                            <!-- Nom + rareté + icône élément -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="me-2">
                                    <h2 class="h5 mb-1"><?= $this->e($p->getName()) ?></h2>
                                    <span class="badge text-bg-dark"><?= $stars($p->getRarity()) ?></span>
                                </div>

                                <?php if ($element && $element->getUrlImg()): ?>
                                    <img
                                            src="<?= $this->e($element->getUrlImg()) ?>"
                                            alt="Élément <?= $this->e($element->getName()) ?>"
                                            class="rounded-circle border"
                                            style="width: 40px; height: 40px; object-fit: cover;"
                                            loading="lazy"
                                            onerror="this.src='https://via.placeholder.com/40?text=?'">
                                <?php endif; ?>
                            </div>

                            <!-- Badges texte (élément / classe) -->
                            <div class="mb-2">
                                <?php if ($element): ?>
                                    <span class="badge text-bg-primary">
                                        <?= $this->e($element->getName()) ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ($unitclass): ?>
                                    <span class="badge text-bg-secondary">
                                        <?= $this->e($unitclass->getName()) ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Origine -->
                            <p class="text-muted mb-3">
                                Origine :
                                <?= $origin ? $this->e($origin->getName()) : '—' ?>
                            </p>

                            <!-- Boutons d’actions -->
                            <div class="mt-auto pt-2 d-flex justify-content-end gap-2 flex-wrap">
                                <a href="index.php?action=edit-perso&idPerso=<?= $this->e($p->getId()) ?>"
                                   class="btn btn-sm btn-outline-warning">
                                    Modifier
                                </a>

                                <a href="index.php?action=del-perso&idPerso=<?= $this->e($p->getId()) ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Supprimer ce personnage ?');">
                                    Supprimer
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
