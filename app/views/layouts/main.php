<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(($pageTitle ?? 'BiblioNet') . ' - BiblioNet') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= e(asset('css/style.css')) ?>" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?= e(url('')) ?>">
            <span class="brand-mark" aria-hidden="true">BN</span>
            BiblioNet
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link<?= ($pageTitle ?? '') === 'Accueil' ? ' active' : '' ?>" href="<?= e(url('')) ?>">Accueil</a></li>
                <?php if (is_logged_in()): ?>
                    <li class="nav-item"><a class="nav-link<?= ($pageTitle ?? '') === 'Livres' ? ' active' : '' ?>" href="<?= e(url('livres')) ?>">Livres</a></li>
                    <li class="nav-item"><a class="nav-link<?= ($pageTitle ?? '') === 'Adhérents' ? ' active' : '' ?>" href="<?= e(url('adherents')) ?>">Adhérents</a></li>
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <?php if (is_logged_in()): ?>
                    <span class="user-name"><?= e($_SESSION['user']['nom']) ?></span>
                    <form method="post" action="<?= e(url('auth/logout')) ?>" class="d-inline">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-light">Déconnexion</button>
                    </form>
                <?php else: ?>
                    <a class="btn btn-sm btn-light" href="<?= e(url('auth/login')) ?>">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main class="site-main flex-grow-1">
    <?php foreach (flash_get() as $f): ?>
        <div class="alert alert-<?= e($f['type']) ?> alert-dismissible fade show" role="alert">
            <?= e($f['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    <?php endforeach; ?>

    <?= $content ?>
</main>

<footer class="site-footer">BiblioNet <span aria-hidden="true">·</span> Gestion de bibliothèque</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
