<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/core/Autoloader.php';

$router = new Router();
$router->run();