<?php

declare(strict_types=1);

class AdminController extends Controller
{
    private function requireLogin(): void
    {
        if (empty($_SESSION['admin_logged_in'])) {
            Flash::set('error', 'Bejelentkezés szükséges.');
            header('Location: ?c=admin&m=login');
            exit;
        }
    }

    public function login(): void
    {
        $this->view('admin/login', [
            'title' => 'Admin bejelentkezés'
        ]);
    }

    public function loginSubmit(): void
    {
        $password = $_POST['password'] ?? '';

        // Egyszerű fix jelszó (később adatbázisba kerülhet)
        $correctPassword = 'admin123';

        if ($password !== $correctPassword) {
            Flash::set('error', 'Hibás jelszó.');
            header('Location: ?c=admin&m=login');
            exit;
        }

        $_SESSION['admin_logged_in'] = true;

        Flash::set('success', 'Sikeres bejelentkezés!');
        header('Location: ?c=admin&m=dashboard');
        exit;
    }

    public function logout(): void
    {
        unset($_SESSION['admin_logged_in']);
        Flash::set('success', 'Kijelentkeztél.');
        header('Location: ?c=admin&m=login');
        exit;
    }

    public function dashboard(): void
    {
        $this->requireLogin();

        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard'
        ]);
    }

    public function bookings(): void
    {
        $this->requireLogin();

        $bookingModel = new Booking();
        $bookings = $bookingModel->getAllWithTimeslots();

        $this->view('admin/bookings', [
            'title' => 'Foglalások listája',
            'bookings' => $bookings
        ]);
    }

    public function deleteBooking(): void
    {
        $this->requireLogin();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            Flash::set('error', 'Hiányzó foglalás ID.');
            header('Location: ?c=admin&m=bookings');
            exit;
        }

        $bookingModel = new Booking();

        if ($bookingModel->delete((int)$id)) {
            Flash::set('success', 'Foglalás törölve.');
        } else {
            Flash::set('error', 'A törlés nem sikerült.');
        }

        header('Location: ?c=admin&m=bookings');
        exit;
    }

    public function timeslots(): void
    {
        $this->requireLogin();

        $model = new Timeslot();
        $timeslots = $model->getAll();

        $this->view('admin/timeslots', [
            'title' => 'Időpontok',
            'timeslots' => $timeslots
        ]);
    }

}
