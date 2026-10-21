<?php
$fields = [
    'titre'          => ['Titre', 'text'],
    'auteur'         => ['Auteur', 'text'],
    'categorie'      => ['Catégorie', 'text'],
    'annee'          => ['Année de publication', 'number'],
    'nb_exemplaires' => ["Nombre d'exemplaires", 'number'],
];
?>
<div class="page-heading">
    <div>
        <div class="eyebrow">Votre collection</div>
        <h1><?= e($formTitle) ?></h1>
        <p>Renseignez les informations de l’ouvrage.</p>
    </div>
</div>

<div class="card form-card">
    <div class="card-body p-4 p-md-5">
        <form method="post" action="<?= e(url($action)) ?>" novalidate>
            <?= csrf_field() ?>
            <?php foreach ($fields as $name => [$label, $type]): ?>
                <div class="mb-3">
                    <label for="<?= e($name) ?>" class="form-label"><?= e($label) ?></label>
                    <input type="<?= e($type) ?>" id="<?= e($name) ?>" name="<?= e($name) ?>"
                           class="form-control<?= isset($errors[$name]) ? ' is-invalid' : '' ?>"
                           value="<?= e($livre[$name] ?? '') ?>" required>
                    <?php if (isset($errors[$name])): ?>
                        <div class="invalid-feedback"><?= e($errors[$name]) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="<?= e(url('livres')) ?>" class="btn btn-link">Annuler</a>
        </form>
    </div>
</div>
