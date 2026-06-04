<h1 class="mb-4">Időpontok listája</h1>

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
                    <th>Időpont</th>
                    <th>Státusz</th>
                    <th>Művelet</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($timeslots as $t): ?>
                    <tr>
                        <td><?= $t['id'] ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($t['slot_datetime'])) ?></td>

                        <!-- státusz előkészítve -->
                        <td>
                            <span class="badge bg-secondary">
                                Szabad
                            </span>
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
