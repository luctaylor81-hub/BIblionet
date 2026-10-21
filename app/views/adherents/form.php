<?php
$fields = [
    'nom'       => ['Nom', 'text'],
    'prenom'    => ['Prénom', 'text'],
    'classe'    => ['Classe', 'text'],
    'telephone' => ['Téléphone (facultatif)', 'text'],
];
?>
<div class="page-heading">
    <div>
        <div class="eyebrow">La communauté</div>
        <h1><?= e($formTitle) ?></h1>
        <p>Renseignez les informations de l’adhérent.</p>
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
                           value="<?= e($adherent[$name] ?? '') ?>"<?= $name !== 'telephone' ? ' required' : '' ?>>
                    <?php if (isset($errors[$name])): ?>
                        <div class="invalid-feedback"><?= e($errors[$name]) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="<?= e(url('adherents')) ?>" class="btn btn-link">Annuler</a>
        </form>
    </div>
</div>
