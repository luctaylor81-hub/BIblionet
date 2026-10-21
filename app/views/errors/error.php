<div class="text-center py-5">
    <h1 class="h3"><?= e($pageTitle ?? 'Erreur') ?></h1>
    <p class="text-muted"><?= e($message ?? 'Une erreur est survenue.') ?></p>
    <a href="<?= e(url('')) ?>" class="btn btn-primary">Retour à l'accueil</a>
</div>
