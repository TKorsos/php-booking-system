<h1 class="mb-4">Dolgozók</h1>

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Név</th>
                    <th>Email</th>
                    <th>Művelet</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($workers as $worker): ?>
                    <tr>
                        <td><?= htmlspecialchars($worker['name']) ?></td>
                        <td><?= htmlspecialchars($worker['email']) ?></td>
                        <td>
                            <a href="?c=admin&m=workerHours&workerId=<?= $worker['id'] ?>"
                               class="btn btn-primary btn-sm">
                                Munkaidő szerkesztése
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>
