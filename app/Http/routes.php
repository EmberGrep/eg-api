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
$router->post('/auth-token', 'Auth\JWTToken@store');

$router->group(['prefix' => 'free-lessons'], function($router) {
    $router->get('/', 'FreeLessons\ListLessons@action');
    $router->get('/{lessonSlug}', 'FreeLessons\FindLessons@action');
});

$router->group(['prefix' => 'course-abstracts'], function($router) {
    $router->get('/', 'CourseAbstracts\ListCourseAbstracts@action');
    $router->get('/{courseSlug}', 'CourseAbstracts\FindCourseAbstract@action');
});
