<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Admin' ?></title>
</head>
<body>

<?php if ($msg = Flash::get('error')): ?>
    <div class="flash error"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<?php if ($msg = Flash::get('success')): ?>
    <div class="flash success"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<?php if (!empty($_SESSION['admin_logged_in'])): ?>
<nav>
    <a href="?c=admin&m=dashboard">Dashboard</a> |
    <a href="?c=admin&m=bookings">Foglalások</a> |
    <a href="?c=admin&m=timeslots">Időpontok</a> |
    <a href="?c=admin&m=logout">Kijelentkezés</a>
</nav>
<hr>
<?php endif; ?>

<?= $content ?>

</body>
</html>
