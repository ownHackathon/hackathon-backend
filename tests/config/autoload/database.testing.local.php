<?php declare(strict_types=1);

return [
    'database' => [
        'host' => 'hackathon-mariadb',
        'port' => '3306',
        'user' => 'dev',
        'password' => 'dev',
        'dbname' => 'db',
        'error' => PDO::ERRMODE_EXCEPTION,
    ]
];
