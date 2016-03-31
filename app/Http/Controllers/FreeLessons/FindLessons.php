<?php namespace EmberGrep\Http\Controllers\FreeLessons;

use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Lesson;

use Manuel\Resource\Item;
use EmberGrep\Http\Transformers\FreeLesson as FreeLessonTransformer;

class FindLessons extends Controller
{
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function action($slug)
    {
        $lesson = $this->lesson->where(['slug' => $slug])->firstOrFail();

        if (!$lesson->free) {
            return response()->json([
                'errors' => [
                    [
                        'status' => '401',
                        'title' => 'Paid Lesson',
                        'detail' => 'The selected lesson is paid Lesson.'
                    ],
                ],
            ], 401);
        }

        $item = new Item($lesson, new FreeLessonTransformer(), 'free-lessons');

        return response()->jsonApi($item);
    }
}
