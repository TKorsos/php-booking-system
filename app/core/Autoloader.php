<?php

spl_autoload_register(function ($class) {

    $paths = [
        __DIR__ . '/' . $class . '.php',                 // core
        __DIR__ . '/../controllers/' . $class . '.php',  // controllers
        __DIR__ . '/../models/' . $class . '.php'        // models
    ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
