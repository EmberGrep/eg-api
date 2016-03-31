<?php

namespace EmberGrep\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\JsonResponse;

use Manuel\Manager;
use Manuel\Serializer\JsonApiSerializer;

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
        $fractal = new Manager(new JsonApiSerializer());
        $response = $this->app->make('Illuminate\Contracts\Routing\ResponseFactory');

        $response->macro('jsonApi', function ($data) use ($fractal) {
            return new JsonResponse($fractal->translate($data));
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
