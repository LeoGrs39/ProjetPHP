<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->e($title ?? 'TP Mihoyo') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/main.css"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
<?php

$action = $_GET['action'] ?? null;
$isActive = function(?string $expected) use ($action) {

    if ($expected === null) {
        return $action === null ? 'active' : '';
    }
    return $action === $expected ? 'active' : '';
};
?>
<header class="shadow-sm sticky-top bg-white">
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="index.php">
                <img src="https://img.icons8.com/color/1200/genshin-impact-logo.jpg" alt="Logo" height="28" class="me-2">
                TP Mihoyo
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
                    aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="nav" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $isActive(null) ?>" href="index.php">
                            <i class="bi bi-house-door me-1"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $isActive('add-perso') ?>" href="index.php?action=add-perso">
                            <i class="bi bi-person-plus me-1"></i> Ajouter un perso
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $isActive('add-perso-element') ?>" href="index.php?action=add-perso-element">
                            <i class="bi bi-stars me-1"></i> Ajouter un élément
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $isActive('logs') ?>" href="index.php?action=logs">
                            <i class="bi bi-journal-text me-1"></i> Logs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $isActive('login') ?>" href="index.php?action=login">
                            <i class="bi bi-person-circle me-1"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container py-4">
    <?= $this->section('content') ?>
</main>

<footer class="border-top py-3 mt-5 bg-white">
    <div class="container small text-muted">© <?= date('Y') ?> — TP Mihoyo</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
