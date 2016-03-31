<?php namespace EmberGrep\Http\Controllers\FreeLessons;

use Illuminate\Http\Request;
use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Lesson;

use Manuel\Resource\Collection;
use EmberGrep\Http\Transformers\FreeLesson as FreeLessonTransformer;

class ListLessons extends Controller
{
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function action()
    {
        $freeLessons = $this->lesson->where(['free' => true])->get();

        $item = new Collection($freeLessons, new FreeLessonTransformer(), 'free-lessons');

        return response()->jsonApi($item);
    }
}
