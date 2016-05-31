<?php namespace EmberGrep\Http\Controllers\Lessons;

use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Lesson;

use Manuel\Resource\Collection;
use EmberGrep\Http\Transformers\Lesson as LessonTransformer;

class ListLessons extends Controller
{
    public function __construct(Lesson $lesson)
    {
        $this->middleware('auth');
        $this->lesson = $lesson;
    }

    public function action()
    {
        $userId = request()->user()->id;

        $freeLessons = $this->lesson->whereHas('course.purchases', function($query) use ($userId) {
            $query->where('purchases.user_id', $userId);
        })->get();

        $item = new Collection($freeLessons, new LessonTransformer(), 'lessons');

        return response()->jsonApi($item);
    }
}
