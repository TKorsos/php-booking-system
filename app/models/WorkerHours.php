<?php

declare(strict_types=1);

class WorkerHours
{
    public int $id;
    public int $workerId;
    public int $dayOfWeek;
    public string $startTime;
    public string $endTime;

    public function __construct(
        int $id,
        int $workerId,
        int $dayOfWeek,
        string $startTime,
        string $endTime
    ) {
        $this->id = $id;
        $this->workerId = $workerId;
        $this->dayOfWeek = $dayOfWeek;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    /**
     * Lekéri egy dolgozó összes munkaidejét napokra bontva.
     * Visszatérés: [ day_of_week => ['start' => '08:00', 'end' => '16:00'], ... ]
     */
    public static function getByWorker(int $workerId): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT * FROM worker_hours
            WHERE worker_id = :worker_id
            ORDER BY day_of_week ASC
        ");
        $stmt->execute(['worker_id' => $workerId]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $hours = [];

        foreach ($rows as $row) {
            $hours[(int)$row['day_of_week']] = [
                'start' => $row['start_time'],
                'end'   => $row['end_time']
            ];
        }

        return $hours;
    }

    /**
     * Egy adott nap munkaidejének lekérése.
     * Ha OFF → null
     */
    public static function getForDay(int $workerId, int $dayOfWeek): ?array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT start_time, end_time
            FROM worker_hours
            WHERE worker_id = :worker_id AND day_of_week = :day
            LIMIT 1
        ");
        $stmt->execute([
            'worker_id' => $workerId,
            'day' => $dayOfWeek
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null; // OFF nap
        }

        return [
            'start' => $row['start_time'],
            'end'   => $row['end_time']
        ];
    }

    /**
     * Munkaidő mentése (insert vagy update).
     */
    public static function save(int $workerId, int $dayOfWeek, string $start, string $end): void
    {
        $db = Database::getConnection();

        // Van már ilyen nap?
        $stmt = $db->prepare("
            SELECT id FROM worker_hours
            WHERE worker_id = :worker_id AND day_of_week = :day
            LIMIT 1
        ");
        $stmt->execute([
            'worker_id' => $workerId,
            'day' => $dayOfWeek
        ]);

        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // UPDATE
            $stmt = $db->prepare("
                UPDATE worker_hours
                SET start_time = :start, end_time = :end
                WHERE id = :id
            ");
            $stmt->execute([
                'start' => $start,
                'end'   => $end,
                'id'    => $existing['id']
            ]);
        } else {
            // INSERT
            $stmt = $db->prepare("
                INSERT INTO worker_hours (worker_id, day_of_week, start_time, end_time)
                VALUES (:worker_id, :day, :start, :end)
            ");
            $stmt->execute([
                'worker_id' => $workerId,
                'day'       => $dayOfWeek,
                'start'     => $start,
                'end'       => $end
            ]);
        }
    }

    /**
     * OFF nap beállítása → töröljük a sort.
     */
    public static function deleteDay(int $workerId, int $dayOfWeek): void
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            DELETE FROM worker_hours
            WHERE worker_id = :worker_id AND day_of_week = :day
        ");
        $stmt->execute([
            'worker_id' => $workerId,
            'day' => $dayOfWeek
        ]);
    }
}
