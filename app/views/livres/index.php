<div class="page-heading">
    <div>
        <div class="eyebrow">Votre collection</div>
        <h1>Livres</h1>
        <p>Consultez et gérez les ouvrages du catalogue.</p>
    </div>
    <a href="<?= e(url('livres/create')) ?>" class="btn btn-primary">+ Ajouter un livre</a>
</div>

<?php if (empty($livres)): ?>
    <div class="empty-state">Aucun livre enregistré pour le moment.</div>
<?php else: ?>
    <div class="table-shell">
        <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th><th>Titre</th><th>Auteur</th><th>Catégorie</th>
                    <th>Année</th><th class="text-center">Exemplaires</th><th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($livres as $l): ?>
                <tr>
                    <td class="table-id"><?= e($l['id']) ?></td>
                    <td class="table-primary-text"><?= e($l['titre']) ?></td>
                    <td><?= e($l['auteur']) ?></td>
                    <td><span class="category-pill"><?= e($l['categorie']) ?></span></td>
                    <td><?= e($l['annee']) ?></td>
                    <td class="text-center"><?= e($l['nb_exemplaires']) ?></td>
                    <td class="text-end text-nowrap">
                        <a href="<?= e(url('livres/edit/' . (int) $l['id'])) ?>" class="btn btn-sm btn-outline-secondary">Modifier</a>
                        <form method="post" action="<?= e(url('livres/delete/' . (int) $l['id'])) ?>" class="d-inline"
                              onsubmit="return confirm('Supprimer ce livre ?');">
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
