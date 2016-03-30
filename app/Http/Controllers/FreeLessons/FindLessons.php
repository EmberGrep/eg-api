<?php namespace EmberGrep\Http\Controllers\FreeLessons;

use Illuminate\Http\Request;
use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Lesson;
use Illuminate\Http\JsonResponse;

use League\Fractal\Resource\Item;
use EmberGrep\Http\Transformers\FreeLesson as FreeLessonTransformer;

class FindLessons extends Controller
{
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;

        $this->middleware('json-api');
    }

    public function action($slug)
    {
        $lesson = $this->lesson->where(['slug' => $slug])->firstOrFail();

        if (!$lesson->free) {
            return new JsonResponse([
                'errors' => [
                    [
                        'status' => '401',
                        'title' => 'Paid Lesson',
                        'detail' => 'The selected lesson is paid Lesson.'
                    ],
                ],
            ], 401);
        }

        return new Item($lesson, new FreeLessonTransformer(), 'lesson');
    }
}
