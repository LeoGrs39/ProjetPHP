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
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm h-100">

                        <div class="ratio ratio-portrait img-frame">
                            <img
                                    class="img-cover"
                                    src="<?= $this->e($p->getUrlImg()) ?>"
                                    alt="Portrait de <?= $this->e($p->getName()) ?>"
                                    loading="lazy"
                                    onerror="this.src='https://via.placeholder.com/600x800?text=No+Image'">
                        </div>

                        <div class="card-body d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h2 class="h5 mb-0"><?= $this->e($p->getName()) ?></h2>
                                <span class="badge text-bg-dark"><?= $stars($p->getRarity()) ?></span>
                            </div>

                            <div class="mb-2">
                                <span class="badge text-bg-primary">
                                    <?= $this->e($p->getElement()?->getName()) ?>
                                </span>

                                <span class="badge text-bg-secondary">
                                    <?= $this->e($p->getUnitclass()?->getName()) ?>
                                </span>
                            </div>

                            <p class="text-muted mb-3">
                                Origine : <?= $this->e($p->getOrigin()?->getName() ?? '—') ?>
                            </p>

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
