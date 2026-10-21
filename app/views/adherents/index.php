<div class="page-heading">
    <div>
        <div class="eyebrow">La communauté</div>
        <h1>Adhérents</h1>
        <p>Retrouvez les membres inscrits à la bibliothèque.</p>
    </div>
    <a href="<?= e(url('adherents/create')) ?>" class="btn btn-primary">+ Ajouter un adhérent</a>
</div>

<?php if (empty($adherents)): ?>
    <div class="empty-state">Aucun adhérent enregistré pour le moment.</div>
<?php else: ?>
    <div class="table-shell">
        <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th><th>Nom</th><th>Prénom</th><th>Classe</th><th>Téléphone</th><th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($adherents as $a): ?>
                <tr>
                    <td class="table-id"><?= e($a['id']) ?></td>
                    <td class="table-primary-text"><?= e($a['nom']) ?></td>
                    <td><?= e($a['prenom']) ?></td>
                    <td><?= e($a['classe']) ?></td>
                    <td><?= e($a['telephone']) ?></td>
                    <td class="text-end text-nowrap">
                        <a href="<?= e(url('adherents/edit/' . (int) $a['id'])) ?>" class="btn btn-sm btn-outline-secondary">Modifier</a>
                        <form method="post" action="<?= e(url('adherents/delete/' . (int) $a['id'])) ?>" class="d-inline"
                              onsubmit="return confirm('Supprimer cet adhérent ?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
<?php endif; ?>
