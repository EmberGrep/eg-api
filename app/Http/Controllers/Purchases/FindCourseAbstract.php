<?php namespace EmberGrep\Http\Controllers\CourseAbstracts;

use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Course;

use League\Fractal\Resource\Item;
use EmberGrep\Http\Transformers\CourseAbstract as CourseAbstractTransformer;

class FindCourseAbstract extends Controller
{
    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function action($slug)
    {
        $course = $this->course->where(['slug' => $slug])->firstOrFail();

        $item = new Item($course, new CourseAbstractTransformer(), 'course-abstracts');

        return response()->jsonApi($item);
    }
}
