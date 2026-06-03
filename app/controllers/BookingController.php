<?php

declare(strict_types=1);

class BookingController extends Controller
{
    public function form(): void
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Hiányzó időpont ID.";
            return;
        }

        $slot = Timeslot::findById((int)$id);

        if (!$slot || $slot->isBooked) {
            echo "Ez az időpont nem foglalható.";
            return;
        }

        $this->view('booking/form', [
            'slot' => $slot
        ]);
    }

    public function submit(): void
    {
        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (!$id || $name === '' || $email === '') {
            echo "Minden mező kötelező.";
            return;
        }

        $slot = Timeslot::findById((int)$id);

        if (!$slot || $slot->isBooked) {
            echo "Ez az időpont már nem foglalható.";
            return;
        }

        // Foglalás mentése
        Booking::create($slot->id, $name, $email);

        // Timeslot frissítése
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE timeslots SET is_booked = 1 WHERE id = :id");
        $stmt->execute(['id' => $slot->id]);

        Flash::set('success', 'Foglalás sikeresen rögzítve!');
        header('Location: ?c=timeslot&m=index&date='. date('Y-m-d'));
        exit;
    }
}
