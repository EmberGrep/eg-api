<?php namespace EmberGrep\Http\Transformers;

use Manuel\Transformer\TransformerAbstract;
use EmberGrep\Models\Course as CourseModel;

class CourseAbstract extends TransformerAbstract
{
    protected $type = 'course-abstracts';

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $relationships = ['lessons' => 'lesson-abstracts'];

    /**
     * Transform only desired properties for API
     *
     * @param CourseModel $course
     * @return array
     */
    public function transform(CourseModel $course)
    {
        $attrs = [
            'id' => $course->slug,
            'name' => $course->name,
            'price' => (int) $course->price,
            'time' => $course->time,
            'active' => $course->active,
            'release-date' => $course->release_date->toIso8601String(),
            'description' => $course->description,
            'long-description' => $course->description_long,
            'coming-soon' => (boolean) $course->coming_soon,
            'purchased' => (boolean) $course->purchased,
        ];

        return $attrs;
    }

    public function relationshipLessons(CourseModel $course)
    {
        return $course->lessons()->lists('id')->toArray();
    }
}
