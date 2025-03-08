<?php

function getDatabaseConfig(): array
{
    return [
        'database' => [
            'development' => [
                'url' => 'mysql:host=localhost:3306;dbname=backend_development',
                'username' => 'root',
                'password' => ''
            ],
            'production' => [
                'url' => 'mysql:host=localhost:3306;dbname=backend',
                'username' => 'root',
                'password' => ''
            ]
        ]
    ];
}
