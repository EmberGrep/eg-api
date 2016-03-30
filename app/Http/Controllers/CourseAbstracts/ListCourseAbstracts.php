<?php namespace EmberGrep\Http\Controllers\CourseAbstracts;

use Illuminate\Http\Request;
use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Course;

use League\Fractal\Resource\Collection;
use EmberGrep\Http\Transformers\CourseAbstract as CourseAbstractTransformer;

class ListCourseAbstracts extends Controller
{
    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function action()
    {
        $freeCourses = $this->course->where(['is_published' => true])->get();

        $item = new Collection($freeCourses, new CourseAbstractTransformer(), 'course-abstracts');

        return response()->jsonApi($item);
    }
}
