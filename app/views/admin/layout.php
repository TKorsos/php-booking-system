<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Admin' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php if (!empty($_SESSION['admin_logged_in'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="?c=admin&m=dashboard">Admin Panel</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="?c=admin&m=dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="?c=admin&m=bookings">Foglalások</a></li>
                <li class="nav-item"><a class="nav-link" href="?c=admin&m=timeslots">Időpontok</a></li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-danger" href="?c=admin&m=logout">Kijelentkezés</a></li>
            </ul>
        </div>
    </div>
</nav>
<?php endif; ?>

<div class="container mt-3">

<?php if ($msg = Flash::get('error')): ?>
    <div class="alert alert-danger text-center"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<?php if ($msg = Flash::get('success')): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

    <?= $content ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
