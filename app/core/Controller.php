<?php

declare(strict_types=1);

class Controller
{
    protected function view(string $path, array $data = []): void
    {
        extract($data);

        ob_start();
        require __DIR__ . "/../views/{$path}.php";
        $content = ob_get_clean();

        if (str_starts_with($path, 'admin/')) {
            require __DIR__ . "/../views/admin/layout.php";
            return;
        }

        echo $content;
    }
}