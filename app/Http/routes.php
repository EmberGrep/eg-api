<?php

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use EmberGrep\Models\User;

$router->post('/register', 'Auth\Register@store');
