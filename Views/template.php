<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->e($title ?? 'TP Mihoyo') ?></title>

    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet">
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="public/css/main.css"/>


    <style>
        body::before, body::after {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: -1;
        }

        body::before {
            background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.15) 0, transparent 40%),
            radial-gradient(circle at 70% 80%, rgba(255,255,255,0.10) 0, transparent 45%);
            animation: floatGlow 14s ease-in-out infinite alternate;
        }

        @keyframes floatGlow {
            from { transform: translateY(0px); }
            to   { transform: translateY(-28px); }
        }

        main {
            animation: fadeIn 0.9s ease forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        .gi-panel {
            background: rgba(22, 26, 44, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 40px rgba(0,0,0,0.45),
            0 0 18px rgba(245,212,123,0.25);
        }

        .gi-logo {
            filter: drop-shadow(0 4px 14px rgba(255,255,255,0.4))
            drop-shadow(0 0 22px rgba(245,212,123,0.35));
        }

    </style>
</head>

<body>

<?php
use Services\AuthService;

$action = $_GET['action'] ?? null;

$isActive = function(?string $expected) use ($action) {
    if ($expected === null) {
        return $action === null ? 'active' : '';
    }
    return $action === $expected ? 'active' : '';
};

$isLogged = AuthService::isAuthenticated();
?>


<header class="shadow-sm sticky-top">
    <nav class="navbar navbar-expand-lg py-3"
         style="
             background: linear-gradient(to bottom,
                 rgba(12,17,32,0.92),
                 rgba(12,17,32,0.65)
             );
             backdrop-filter: blur(12px);
             border-bottom: 1px solid rgba(255,255,255,0.15);
         ">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="index.php" style="color:#f6e8bb;">
                <img src="https://img.icons8.com/color/1200/genshin-impact-logo.jpg"
                     alt="Logo" height="32"
                     class="me-2 gi-logo">
                TP Mihoyo
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="nav" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link <?= $isActive(null) ?>"
                           href="index.php">
                            <i class="bi bi-house-door me-1"></i> Accueil
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= $isActive('add-perso') ?>"
                           href="index.php?action=add-perso">
                            <i class="bi bi-person-plus me-1"></i> Ajouter un perso
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= $isActive('add-perso-element') ?>"
                           href="index.php?action=add-perso-element">
                            <i class="bi bi-stars me-1"></i> Ajouter un élément
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= $isActive('logs') ?>"
                           href="index.php?action=logs">
                            <i class="bi bi-journal-text me-1"></i> Logs
                        </a>
                    </li>


                    <?php if (!$isLogged): ?>
                        <!-- Si NON connecté : lien Login -->
                        <li class="nav-item">
                            <a class="nav-link <?= $isActive('login') ?>"
                               href="index.php?action=login">
                                <i class="bi bi-person-circle me-1"></i> Login
                            </a>
                        </li>
                    <?php else: ?>
                        <!-- Si connecté : lien Logout -->
                        <li class="nav-item">
                            <a class="nav-link <?= $isActive('logout') ?>"
                               href="index.php?action=logout">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>


<main id="contenu" class="container py-5">

    <div class="gi-panel">

        <!-- Message global -->
        <?= $this->insert('message', ['message' => $message ?? null]) ?>

        <!-- Contenu -->
        <?= $this->section('content') ?>

    </div>

</main>


<footer class="py-4 mt-5"
        style="
            background: linear-gradient(to top,
                rgba(12,17,32,0.95),
                rgba(12,17,32,0.6)
            );
            border-top: 1px solid rgba(255,255,255,0.12);
            text-align:center;
        ">
    <div class="container small" style="color:#d2d6ef;">
        © <?= date('Y') ?> — TP Mihoyo
        <br><span style="opacity:0.6;">Projet créé avec passion et magie ✦ (et persévérance...)</span>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
