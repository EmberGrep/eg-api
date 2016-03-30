<?php

namespace EmberGrep\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\JsonResponse;

use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

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
        $fractal = new Manager();
        $fractal->setSerializer(new JsonApiSerializer());
        $response = $this->app->make('Illuminate\Contracts\Routing\ResponseFactory');

        $response->macro('jsonApi', function ($data) use ($fractal) {
            return new JsonResponse($fractal->createData($data)->toArray());
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
