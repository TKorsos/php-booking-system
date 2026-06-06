<!-- <pre><?php var_dump($timeslots); ?></pre> -->
 <pre><?php var_dump(gettype($timeslots)); ?></pre>

<h1 class="mb-4">Időpontok listája</h1>

<?php if (empty($timeslots)): ?>

    <div class="alert alert-info text-center">
        Nincs még generált időpont.
    </div>

<?php else: ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <!-- SZŰRŐ FORM -->
            <form method="get" class="mb-4">
                <input type="hidden" name="c" value="admin">
                <input type="hidden" name="m" value="timeslots">

                <div>
                    <label for="worker" class="form-label">Dolgozó szűrés:</label>
                    <select name="worker" id="worker" class="form-select" onchange="this.form.submit()">
                        <option value="">Összes dolgozó</option>

                        <?php foreach ($workers as $worker): ?>
                            <option value="<?= $worker->id ?>"
                                <?= ($selectedWorker == $worker->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($worker->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>

            <!-- TÁBLÁZAT -->
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-striped table-hover align-middle table-sm text-nowrap">
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
                                    <?php if (!$selectedWorker): ?>
                                        <td><?= htmlspecialchars($t['worker_name']) ?></td>
                                    <?php endif; ?>
                                    <td><?= date('Y-m-d H:i', strtotime($t['slot_datetime'])) ?></td>
                                    <td>
                                        <?php if ($t['is_booked']): ?>
                                            <span class="badge bg-danger">Foglalt</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Szabad</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!$t['is_booked']): ?>
                                            <a href="?c=admin&m=deleteTimeslot&id=<?= $t['id'] ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Biztosan törlöd ezt az időpontot?');">
                                                Törlés
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                Nem törölhető
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            
        </div>
    </div>

<?php endif; ?>
