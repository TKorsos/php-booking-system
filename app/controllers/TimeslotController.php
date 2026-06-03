<?php

declare(strict_types=1);

class TimeslotController extends Controller
{
    public function index(): void {
        $workerId = 1;
        $date = $_GET['date'] ?? date('Y-m-d');

        $worker = Worker::findById($workerId);
        $slots = Timeslot::getByDate($date, $workerId);

        $this->view('timeslots/index', [
            'date' => $date,
            'worker' => $worker,
            'slots' => $slots
        ]);
    }
}
