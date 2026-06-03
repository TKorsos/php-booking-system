<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Időpontok - <?= htmlspecialchars($date) ?></title>
    <style>
        /* Szervezd ki external css fájlba! */
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        h1 {
            margin-bottom: 10px;
        }
        .date-nav {
            margin-bottom: 20px;
        }
        .date-nav a {
            padding: 8px 14px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-right: 10px;
        }
        .slot {
            padding: 12px;
            background: white;
            margin-bottom: 8px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            border-left: 5px solid #28a745;
        }
        .slot.booked {
            border-left-color: #dc3545;
            opacity: 0.6;
        }
        .flash.success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<?php if ($msg = Flash::get('success')): ?>
    <div class="flash success">
        <?= htmlspecialchars($msg) ?>
    </div>
<?php endif; ?>

<h1>
    Időpontok - <?= htmlspecialchars($date) ?>
    (<?= date('l', strtotime($date)) ?>)
</h1>

<div class="date-nav">
    <a href="?c=timeslot&m=index&date=<?= date('Y-m-d', strtotime('-1 day', strtotime($date))) ?>">Előző nap</a>
    <a href="?c=timeslot&m=index&date=<?= date('Y-m-d', strtotime('+1 day', strtotime($date))) ?>">Következő nap</a>
</div>

<?php if (empty($slots)): ?>
    <p>Nincs időpont erre a napra.</p>
<?php else: ?>
    <?php foreach ($slots as $slot): ?>
        <div class="slot <?= $slot->isBooked ? 'booked' : '' ?>">
            <strong><?= date('H:i', strtotime($slot->slotDatetime)) ?></strong>

            <?php if (!$slot->isBooked): ?>
                <a href="?c=booking&m=form&id=<?= $slot->id ?>">Foglalás</a>
            <?php else: ?>
                <span>Foglalt</span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
