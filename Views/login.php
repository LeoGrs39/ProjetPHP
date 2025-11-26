<?php $this->layout('template', ['title' => 'Connexion']); ?>

<section class="container mt-2">
    <h1 class="h3 mb-4">Connexion</h1>

    <?php if (!empty($_SESSION['auth_error'])): ?>
        <div class="alert alert-danger">
            <?= $this->e($_SESSION['auth_error']); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="index.php?action=login">
        <div class="mb-3">
            <label for="username" class="form-label">Nom d’utilisateur</label>
            <input
                    type="text"
                    class="form-control"
                    id="username"
                    name="username"
                    required
            >
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    required
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Se connecter
        </button>
    </form>
</section>
