<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card login-card">
            <div class="card-body p-4 p-md-5">
                <div class="login-heading">
                    <div class="eyebrow">Espace bibliothécaire</div>
                    <h1 class="h3">Bon retour parmi nous</h1>
                    <p>Connectez-vous pour gérer votre bibliothèque.</p>
                </div>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2"><?= e($error) ?></div>
                <?php endif; ?>
                <form method="post" action="<?= e(url('auth/login')) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= e($email ?? '') ?>" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</div>
