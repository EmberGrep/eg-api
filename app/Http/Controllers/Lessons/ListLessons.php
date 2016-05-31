<?php namespace EmberGrep\Http\Controllers\Lessons;

use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Lesson;

use Manuel\Resource\Collection;
use EmberGrep\Http\Transformers\Lesson as LessonTransformer;

class ListLessons extends Controller
{
    public function __construct(Lesson $lesson)
    {
        $this->middleware('optional-auth');
        $this->lesson = $lesson;
    }

    public function action()
    {
        $freeLessons = $this->lesson->get();

        $item = new Collection($freeLessons, new LessonTransformer(), 'lessons');

        return response()->jsonApi($item);
    }
}
