<h1 class="mb-4">Időpontok listája</h1>

<div class="card shadow-sm mb-4">
    <div class="card-body">

        <form method="get" class="row g-3">
            <input type="hidden" name="c" value="admin">
            <input type="hidden" name="m" value="timeslots">

            <div class="col-md-4">
                <label for="worker" class="form-label">Dolgozó szűrés:</label>
                <select name="worker" id="worker" class="form-select" onchange="this.form.submit()">
                    <option value="">Összes dolgozó</option>

                    <?php foreach ($workers as $worker): ?>
                        <option value="<?= $worker['id'] ?>"
                            <?= ($selectedWorker == $worker['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($worker['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </form>

    </div>
</div>

<?php if (empty($timeslots)): ?>

    <div class="alert alert-info text-center">
        Nincs még generált időpont.
    </div>

<?php else: ?>

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>

                    <?php if (!$selectedWorker): ?>
                        <th>Dolgozó</th>
                    <?php endif; ?>

                    <th>Időpont</th>
                    <th>Státusz</th>
                    <th>Művelet</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($timeslots as $t): ?>
                    <tr>
                        <td><?= $t['id'] ?></td>

                        <!-- ha az összes dolgozó van kiválasztva -->
                        <?php if (!$selectedWorker): ?>
                            <td><?= htmlspecialchars($t['worker_name']) ?></td>
                        <?php endif; ?>

                        <td><?= date('Y-m-d H:i', strtotime($t['slot_datetime'])) ?></td>

                        <!-- státusz előkészítve -->
                        <td>
                            <?php if ($t['is_booked']): ?>
                                <span class="badge bg-danger">Foglalt</span>
                            <?php else: ?>
                                <span class="badge bg-success">Szabad</span>
                            <?php endif; ?>
                        </td>


                        <!-- törlés gomb előkészítve, egyelőre disabled -->
                        <td>
                            <button class="btn btn-sm btn-danger" disabled>
                                Törlés
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

    </div>
</div>

<?php endif; ?>
