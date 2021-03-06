<?php

namespace EmberGrep\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\JsonResponse;

use Manuel\Manager;
use Manuel\Serializer\JsonAPISerializer;

class JsonSerializeMacroProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $app = $this->app;
        $fractal = new Manager(new JsonAPISerializer());
        $response = $this->app->make('Illuminate\Contracts\Routing\ResponseFactory');

        $response->macro('jsonApi', function ($data, $statusCode = 200) use ($fractal) {
            return new JsonResponse($fractal->translate($data), $statusCode);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
