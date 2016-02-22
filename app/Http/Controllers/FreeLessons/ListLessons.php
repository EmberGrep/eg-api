<?php namespace EmberGrep\Http\Controllers\FreeLessons;

use Illuminate\Http\Request;
use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Lesson;

use Illuminate\Http\JsonResponse;

class ListLessons extends Controller
{
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function action()
    {
        $freeLessons = $this->lesson->where(['free' => true])->get();

        return [
            'data' => $freeLessons->map(function ($lesson) {
                return [
                    'type' => 'free-lessons',
                    'id' => $lesson->slug,
                    'attributes' => [
                        'title' => $lesson->title,
                        'position' => $lesson->position,
                    ],
                ];
            }),
        ];
    }
}
