<?php

declare(strict_types=1);

class TimeslotGenerator
{
    private Worker $worker;

    public function __construct(Worker $worker)
    {
        $this->worker = $worker;
    }

    public function generateForDate(string $date): void
    {
        $dayOfWeek = (int)date('w', strtotime($date)); // 0 = Sunday, 6 = Saturday

        // Sunday closed
        if ($dayOfWeek === 0 && $this->worker->isSundayClosed) {
            return;
        }

        // Determine working hours
        if ($dayOfWeek === 6) {
            // Saturday
            if ($this->worker->saturdayStart === null || $this->worker->saturdayEnd === null) {
                return;
            }

            $start = $this->worker->saturdayStart;
            $end = $this->worker->saturdayEnd;

        } else {
            // Weekdays
            $start = $this->worker->workStart;
            $end = $this->worker->workEnd;
        }

        $current = new DateTime("$date $start");
        $endTime = new DateTime("$date $end");

        while ($current < $endTime) {
            $slot = $current->format('Y-m-d H:i:s');

            Timeslot::create($this->worker->id, $slot);

            $current->modify('+30 minutes');
        }
    }

    public function generateForRange(string $startDate, string $endDate): void
    {
        $current = new DateTime($startDate);
        $end = new DateTime($endDate);

        while ($current <= $end) {
            $this->generateForDate($current->format('Y-m-d'));
            $current->modify('+1 day');
        }
    }

    public function generateNext30Days(): void
    {
        $today = date('Y-m-d');
        $end = date('Y-m-d', strtotime('+30 days'));

        $this->generateForRange($today, $end);
    }
}