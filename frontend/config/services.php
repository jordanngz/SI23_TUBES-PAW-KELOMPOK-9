<?php

return [
    'auth' => [
        'url' => env('AUTH_SERVICE_URL', 'http://auth-service:8000'),
    ],
    'menu' => [
        'url' => env('MENU_SERVICE_URL', 'http://menu-service:8000'),
    ],
    'reservation' => [
        'url' => env('RESERVATION_SERVICE_URL', 'http://reservation-service:8000'),
    ],
    'cart' => [
        'url' => env('CART_SERVICE_URL', 'http://cart-service:8000'),
    ],
    'special_table' => [
        'url' => env('SPECIAL_SERVICE_URL', 'http://special-table-service:8000'),
        'token' => env('SPECIAL_SERVICE_TOKEN', 'kerapu-special-table-secret-2026'),
    ],
];
