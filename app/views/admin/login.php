<?php if ($msg = Flash::get('error')): ?>
    <div class="alert alert-danger text-center"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">

        <div class="card shadow-sm">
            <div class="card-body">

                <h3 class="text-center mb-4">Admin bejelentkezés</h3>

                <form action="?c=admin&m=loginSubmit" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Jelszó</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Belépés
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>
