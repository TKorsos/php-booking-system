<?php

declare(strict_types=1);

class Booking
{
    public int $id;
    public int $timeslot_id;
    public string $customer_name;
    public string $customer_email;
    public string $created_at;

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

    public static function findByTimeslot(int $timeslotId): ?Booking
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM bookings WHERE timeslot_id = :id LIMIT 1");
        $stmt->execute(['id' => $timeslotId]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $booking = $stmt->fetch();

        return $booking ?: null;
    }
}