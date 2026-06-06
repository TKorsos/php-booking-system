<?php

declare(strict_types=1);

class Worker
{
    public int $id;
    public string $name;
    public string $email;

    public function __construct(int $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
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
            $row['email']
        );
    }

    public static function getAll(): array
    {
        $db = Database::getConnection();

        $stmt = $db->query("SELECT * FROM workers ORDER BY name ASC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $workers = [];

        foreach ($rows as $row) {
            $workers[] = new Worker(
                (int)$row['id'],
                $row['name'],
                $row['email']
            );
        }

        return $workers;
    }

    public static function getAllWithTimeslots(): array
    {
        $db = Database::getConnection();

        $stmt = $db->query("
            SELECT w.*
            FROM workers w
            ORDER BY w.name ASC
        ");

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $workers = [];

        foreach ($rows as $row) {
            $workers[] = new Worker(
                (int)$row['id'],
                $row['name'],
                $row['email']
            );
        }

        return $workers;
    }

}
