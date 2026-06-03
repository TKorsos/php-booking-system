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
}
