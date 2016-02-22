<?php

use Illuminate\Http\JsonResponse;

$router->get('/', function() {
    return new JsonResponse([
        'version' => '0.0.1',
        'links' => [
            'self' => Request::root(),
        ]
    ]);
});

$router->post('/register', 'Auth\Register@store');
