<?php namespace EmberGrep\Http\Controllers\PurchasedCourses;

use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Course;

use Manuel\Resource\Collection;
use EmberGrep\Http\Transformers\PurchasedCourse as PurchasedCourseTransformer;

class ListPurchasedCourses extends Controller
{
    public function __construct(Course $course)
    {
        $this->middleware('auth');
        $this->course = $course;
    }

    public function action()
    {
        $userId = request()->user()->id;

        $courses = $this->course->whereHas('purchases', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where(['is_published' => true])->get();

        $item = new Collection($courses, new PurchasedCourseTransformer(), 'courses');

        return response()->jsonApi($item);
    }
}
