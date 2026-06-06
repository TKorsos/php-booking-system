<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Foglalás - <?= date('H:i', strtotime($slot['slot_datetime'])) ?></title>
</head>
<body>

<h1>Foglalás</h1>

<p>
    Időpont: <strong><?= date('Y-m-d H:i', strtotime($slot['slot_datetime'])) ?></strong>
</p>

<form action="?c=booking&m=submit" method="POST">
    <input type="hidden" name="id" value="<?= $slot['id'] ?>">

    <label>Név:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <button type="submit">Foglalás elküldése</button>
</form>

</body>
</html>

