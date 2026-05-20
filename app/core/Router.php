<?php

declare(strict_types=1);

class Router
{
    public function run(): void
    {
        $controller = $_GET['c'] ?? 'home';
        $method = $_GET['m'] ?? 'index';

        $controllerName = ucfirst($controller) . 'Controller';
        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            echo "Controller not found.";
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            echo "Controller class not found.";
            return;
        }

        $obj = new $controllerName();

        if (!method_exists($obj, $method)) {
            echo "Method not found.";
            return;
        }

        $obj->$method();
    }
}