<?php

declare(strict_types=1);

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}