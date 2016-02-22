<?php

namespace EmberGrep\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs;

    protected function throwValidationException(Validator $validator)
    {
        $errors = array_map(function ($err) {
            return [
                'status' => '400',
                'title' => 'Invalid Attribute',
                'detail' => $err,
            ];
        }, $validator->errors()->all());

        throw new ValidationException($validator, new JsonResponse([
            'errors' => $errors,
        ], 400));
    }
}
