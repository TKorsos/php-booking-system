<h1>Foglalások listája</h1>

<?php if (empty($bookings)): ?>
    <p>Nincs még foglalás.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Időpont</th>
            <th>Név</th>
            <th>Email</th>
            <th>Művelet</th>
        </tr>

        <?php foreach ($bookings as $b): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= date('Y-m-d H:i', strtotime($b['slot_datetime'])) ?></td>
                <td><?= htmlspecialchars($b['customer_name']) ?></td>
                <td><?= htmlspecialchars($b['customer_email']) ?></td>
                <td>
                    <a href="?c=admin&m=deleteBooking&id=<?= $b['id'] ?>"
                       onclick="return confirm('Biztos törlöd?');">
                        Törlés
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
