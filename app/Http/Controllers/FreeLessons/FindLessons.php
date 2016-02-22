<?php namespace EmberGrep\Http\Controllers\FreeLessons;

use Illuminate\Http\Request;
use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Lesson;

use Illuminate\Http\JsonResponse;

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

        return [
            'data' => [
                'type' => 'free-lessons',
                'id' => $lesson->slug,
                'attributes' => [
                    'title' => $lesson->title,
                    'position' => $lesson->position,
                ],
            ]
        ];
    }
}
