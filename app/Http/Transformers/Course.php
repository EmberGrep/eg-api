<?php namespace EmberGrep\Http\Transformers;

use Manuel\Transformer\TransformerAbstract;
use EmberGrep\Models\Course as CourseModel;

class Course extends TransformerAbstract
{
    protected $type = 'courses';

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        // 'lessons',
    ];

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

    // protected function includeLessons(CourseModel $course)
    // {
    //     return $this->collection($course->lessons, new LessonAbstract(), 'lesson-abstracts');
    // }
}
