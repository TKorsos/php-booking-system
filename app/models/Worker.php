<?php

declare(strict_types=1);

class Worker 
{
    public int $id;
    public string $name;
    public string $workStart;
    public string $workEnd;
    public ?string $saturdayStart;
    public ?string $saturdayEnd;
    public bool $isSundayClosed;

    public function __construct(
        int $id,
        string $name,
        string $workStart,
        string $workEnd,
        ?string $saturdayStart,
        ?string $saturdayEnd,
        bool $isSundayClosed
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->workStart = $workStart;
        $this->workEnd = $workEnd;
        $this->saturdayStart = $saturdayStart;
        $this->saturdayEnd = $saturdayEnd;
        $this->isSundayClosed = $isSundayClosed;
    }

    public static function findById(int $id): ?Worker
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM workers WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Worker(
            (int)$row['id'],
            $row['name'],
            $row['work_start'],
            $row['work_end'],
            $row['saturday_start'],
            $row['saturday_end'],
            (bool)$row['is_sunday_closed']
        );
    }

    public static function getAll(): array
    {
        $db = Database::getConnection();

        $stmt = $db->query("SELECT * FROM workers ORDER BY id ASC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $workers = [];

        foreach ($rows as $row) {
            $workers[] = new Worker(
                (int)$row['id'],
                $row['name'],
                $row['work_start'],
                $row['work_end'],
                $row['saturday_start'],
                $row['saturday_end'],
                (bool)$row['is_sunday_closed']
            );
        }

        return $workers;
    }
}