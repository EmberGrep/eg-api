<?php namespace EmberGrep\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class JsonSerialize
{
    /**
     * @var \League\Fractal\Manager
     */
    private $fractal;
    /**
     * @var \Illuminate\Http\JsonResponse
     */
    private $response;

    public function __construct(Manager $fractal, JsonResponse $response)
    {
        $fractal->setSerializer(new JsonApiSerializer());
        $this->fractal = $fractal;

        $this->response = $response;
    }

    public function handle(Request $request, $next)
    {
        $data = $next($request);

        if ($data instanceof \League\Fractal\Resource\ResourceInterface) {
            $this->response->setData($this->fractal->createData($data)->toArray());

            return $this->response;
        }

        return $data;
    }
}
