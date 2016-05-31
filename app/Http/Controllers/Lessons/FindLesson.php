<?php namespace EmberGrep\Http\Controllers\Lessons;

use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Lesson;

use Manuel\Resource\Item;
use EmberGrep\Http\Transformers\Lesson as LessonTransformer;

class FindLesson extends Controller
{
    public function __construct(Lesson $lesson)
    {
        $this->middleware('auth');
        $this->lesson = $lesson;
    }

    public function action($slug)
    {
        $userId = request()->user()->id;

        $freeLessons = $this->lesson->whereHas('course.purchases', function($query) use ($userId, $slug) {
            $query->where(['purchases.user_id' => $userId, 'lessons.slug' => $slug]);
        })->firstOrFail();

        $item = new Item($freeLessons, new LessonTransformer(), 'lessons');

        return response()->jsonApi($item);
    }
}
