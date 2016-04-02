<?php namespace EmberGrep\Http\Controllers\LessonAbstracts;

use Illuminate\Http\Request;
use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Lesson;

use Manuel\Resource\Collection;
use EmberGrep\Http\Transformers\LessonAbstract as LessonAbstractTransformer;

class ListLessonAbstracts extends Controller
{
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function action()
    {
        $freeLessons = $this->lesson->get();

        $item = new Collection($freeLessons, new LessonAbstractTransformer(), 'lesson-abstracts');

        return response()->jsonApi($item);
    }
}
