<?php $this->layout('template', ['title' => $title ?? 'Logs']) ?>

<div class="container my-4">
    <h1 class="mb-4">Logs</h1>

    <?php if (empty($logFiles)): ?>
        <div class="alert alert-info">
            Aucun fichier de log disponible pour le moment.
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-3 mb-3">
                <h2 class="h5">Mois disponibles</h2>
                <div class="list-group">
                    <?php foreach ($logFiles as $file): ?>
                        <?php $isActive = ($file === ($selectedFile ?? null)); ?>
                        <a href="index.php?action=logs&file=<?= urlencode($file) ?>"
                           class="list-group-item list-group-item-action <?= $isActive ? 'active' : '' ?>">
                            <?= $this->e($file) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-9">
                <h2 class="h5 mb-3">
                    <?= $selectedFile ? 'Contenu du log : '.$this->e($selectedFile) : 'Aucun fichier sélectionné'; ?>
                </h2>

                <?php if (!empty($logContent)): ?>
                    <pre class="bg-dark text-light p-3 rounded small"
                         style="white-space: pre-wrap; max-height: 70vh; overflow:auto;">
<?= $this->e($logContent) ?>
                    </pre>
                <?php else: ?>
                    <div class="alert alert-secondary">
                        Ce fichier de log est vide.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
