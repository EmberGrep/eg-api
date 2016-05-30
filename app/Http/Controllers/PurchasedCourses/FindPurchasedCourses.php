<?php namespace EmberGrep\Http\Controllers\PurchasedCourses;

use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Course;

use Manuel\Resource\Item;
use EmberGrep\Http\Transformers\PurchasedCourse as PurchasedCourseTransformer;

class FindPurchasedCourses extends Controller
{
    public function __construct(Course $course)
    {
        $this->middleware('auth');
        $this->course = $course;
    }

    public function action($courseSlug)
    {
        $userId = request()->user()->id;

        $course = $this->course->whereHas('purchases', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where(['is_published' => true, 'slug' => $courseSlug])->firstOrFail();

        $item = new Item($course, new PurchasedCourseTransformer(), 'courses');

        return response()->jsonApi($item);
    }
}
