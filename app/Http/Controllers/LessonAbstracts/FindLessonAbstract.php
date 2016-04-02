<?php namespace EmberGrep\Http\Controllers\LessonAbstracts;

use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Lesson;

use Manuel\Resource\Item;
use EmberGrep\Http\Transformers\LessonAbstract as LessonAbstractTransformer;

class FindLessonAbstract extends Controller
{
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function action($slug)
    {
        $lesson = $this->lesson->where(['slug' => $slug])->firstOrFail();

        $item = new Item($lesson, new LessonAbstractTransformer(), 'lesson-abstracts');

        return response()->jsonApi($item);
    }
}
