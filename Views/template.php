<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->e($title ?? 'TP Mihoyo') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/main.css"/>
</head>
<body class="bg-light">
<header class="border-bottom bg-white">
    <nav class="navbar navbar-expand-lg container">
        <a class="navbar-brand fw-bold" href="#">TP Mihoyo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="nav" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Accueil</a></li>
            </ul>
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
