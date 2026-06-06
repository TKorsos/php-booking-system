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

        if (!$slot || $slot['is_booked']) {
            Flash::set('error', 'Ez az időpont nem foglalható.');
            header('Location: ?c=timeslot&m=index&date=' . date('Y-m-d'));
            exit;
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
            Flash::set('error', 'Minden mező kötelező.');
            header('Location: ?c=timeslot&m=index&date=' . date('Y-m-d'));
            exit;
        }

        $slot = Timeslot::findById((int)$id);

        if (!$slot || $slot['is_booked']) {
            Flash::set('error', 'Ez az időpont nem foglalható.');
            header('Location: ?c=timeslot&m=index&date=' . date('Y-m-d'));
            exit;
        }

        // Dupla foglalás ellenőrzése
        if (Booking::findByTimeslot($slot['id'])) {
            Flash::set('error', 'Ez az időpont már foglalt.');
            header('Location: ?c=timeslot&m=index&date=' . date('Y-m-d'));
            exit;
        }

        // Foglalás mentése
        try {
            Booking::create($slot['id'], $name, $email);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') { // UNIQUE constraint violation
                Flash::set('error', 'Ez az időpont időközben foglalttá vált.');
                header('Location: ?c=timeslot&m=index&date=' . date('Y-m-d'));
                exit;
            }
            throw $e;
        }

        // Timeslot frissítése
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE timeslots SET is_booked = 1 WHERE id = :id");
        $stmt->execute(['id' => $slot['id']]);

        Flash::set('success', 'Foglalás sikeresen rögzítve!');
        header('Location: ?c=timeslot&m=index&date='. date('Y-m-d'));
        exit;
    }
}
