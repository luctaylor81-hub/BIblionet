<section class="hero mb-4">
    <div class="hero-content">
        <div class="eyebrow">Votre bibliothèque, simplement</div>
        <h1>Chaque livre a une histoire. Faites-la vivre.</h1>
        <p>Retrouvez en un seul endroit les livres et les adhérents de votre bibliothèque.</p>
        <div class="d-flex flex-column flex-sm-row gap-2">
            <?php if (is_logged_in()): ?>
                <a href="<?= e(url('livres')) ?>" class="btn btn-light px-4 py-2">Gérer les livres</a>
                <a href="<?= e(url('adherents')) ?>" class="btn btn-outline-light px-4 py-2">Voir les adhérents</a>
            <?php else: ?>
                <a href="<?= e(url('auth/login')) ?>" class="btn btn-light px-4 py-2">Accéder à mon espace <span aria-hidden="true">→</span></a>
            <?php endif; ?>
        </section>
    </div>
</div>

<div class="row g-3 stats-grid">
    <div class="col-sm-6">
        <div class="stat-card">
            <div class="stat-label">Livres au catalogue</div>
            <div class="stat-value"><?= e($nbLivres) ?></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="stat-card">
            <div class="stat-label">Adhérents inscrits</div>
            <div class="stat-value"><?= e($nbAdherents) ?></div>
        </div>
    </div>
</div>
