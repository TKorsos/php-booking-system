<h1 class="mb-4">Foglalások listája</h1>

<?php if (empty($bookings)): ?>

    <div class="alert alert-info text-center">
        Nincs még foglalás.
    </div>

<?php else: ?>

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Időpont</th>
                    <th>Név</th>
                    <th>Email</th>
                    <th>Művelet</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td><?= $b['id'] ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($b['slot_datetime'])) ?></td>
                        <td><?= htmlspecialchars($b['customer_name']) ?></td>
                        <td><?= htmlspecialchars($b['customer_email']) ?></td>
                        <td>
                            <a href="?c=admin&m=deleteBooking&id=<?= $b['id'] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Biztos törlöd?');">
                                Törlés
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

    </div>
</div>

<?php endif; ?>

