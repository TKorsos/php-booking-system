<?php

declare(strict_types=1);

class Timeslot
{

    public function __construct()
    {
        
    }

    public function getAll(): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT t.*, w.name AS worker_name
            FROM timeslots t
            LEFT JOIN workers w ON w.id = t.worker_id
            ORDER BY t.slot_datetime ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM timeslots WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    public static function getByDate(string $date, int $workerId): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT * FROM timeslots 
            WHERE DATE(slot_datetime) = :date 
            AND worker_id = :workerId 
            ORDER BY slot_datetime ASC
        ");

        $stmt->execute([
            'date' => $date,
            'workerId' => $workerId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function markAsFree(int $id): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            UPDATE timeslots 
            SET is_booked = 0 
            WHERE id = :id
        ");

        return $stmt->execute(['id' => $id]);
    }

    public static function getByWorker(int $workerId): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT t.*, w.name AS worker_name
            FROM timeslots t
            JOIN workers w ON w.id = t.worker_id
            WHERE t.worker_id = :workerId
            ORDER BY t.slot_datetime ASC
        ");

        $stmt->execute(['workerId' => $workerId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(int $workerId, string $slotDatetime): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("INSERT INTO timeslots (worker_id, slot_datetime, is_booked) VALUES (:workerId, :slotDatetime, 0)");

        return $stmt->execute([
            'workerId' => $workerId,
            'slotDatetime' => $slotDatetime
        ]);
    }

    public static function delete(int $id): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("DELETE FROM timeslots WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}