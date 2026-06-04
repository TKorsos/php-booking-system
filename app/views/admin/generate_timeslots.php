<h1 class="mb-4">Időpontok generálása</h1>

<?php if ($msg = Flash::get('success')): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($msg) ?>
    </div>
<?php endif; ?>

<?php if ($msg = Flash::get('error')): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($msg) ?>
    </div>
<?php endif; ?>

<div class="card" style="max-width: 500px;">
    <div class="card-body">

        <form method="post" action="?c=admin&m=generateTimeslotsSubmit">

            <div class="mb-3">
                <label for="start_date" class="form-label">Kezdő dátum</label>
                <input type="date" id="start_date" name="start_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">Vég dátum</label>
                <input type="date" id="end_date" name="end_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Időpontok generálása
            </button>

        </form>

    </div>
</div>
