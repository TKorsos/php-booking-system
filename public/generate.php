<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/core/Autoloader.php';
/*
require_once '../app/models/Worker.php';
require_once '../app/models/Timeslot.php';
require_once '../app/services/TimeslotGenerator.php';
require_once '../app/core/Database.php';
*/

$worker = Worker::findById(1);

if ($worker) {
    $generator = new TimeslotGenerator($worker);
    $generator->generateNext30Days();
    echo "Timeslots generated!";
} else {
    echo "Worker not found!";
}
