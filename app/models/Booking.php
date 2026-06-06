<?php

declare(strict_types=1);

class Booking
{
    public int $id;
    public int $timeslot_id;
    public string $customer_name;
    public string $customer_email;
    public string $created_at;

    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM bookings WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    public static function findByTimeslot(int $timeslotId): ?Booking
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM bookings WHERE timeslot_id = :id LIMIT 1");
        $stmt->execute(['id' => $timeslotId]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $booking = $stmt->fetch();

        return $booking ?: null;
    }

    public function getAllWithTimeslots(): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT 
                bookings.id,
                bookings.customer_name,
                bookings.customer_email,
                timeslots.slot_datetime
            FROM bookings
            INNER JOIN timeslots ON bookings.timeslot_id = timeslots.id
            ORDER BY timeslots.slot_datetime ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(int $timeslotId, string $name, string $email): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            INSERT INTO bookings (timeslot_id, customer_name, customer_email) 
            VALUES (:timeslot_id, :name, :email)
        ");

        return $stmt->execute([
            'timeslot_id' => $timeslotId,
            'name' => $name,
            'email' => $email
        ]);
    }

    public function delete(int $id): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("DELETE FROM bookings WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

}