<?php namespace EmberGrep\Http\Transformers;

use EmberGrep\Models\Lesson;
use Manuel\Transformer\TransformerAbstract;

use Manuel\Resource\Item;

class LessonAbstract extends TransformerAbstract
{
    protected $type = 'lesson-abstracts';

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $includedResources = [
    ];

    /**
     * Transform only desired properties for API
     *
     * @param Lesson $lesson
     * @return array
     */
    public function transform(Lesson $lesson)
    {
        $attrs = [
            'id'      => $lesson->slug,
            'title' => $lesson->title,
            'time' => (int) $lesson->time,
            'description' => $lesson->description,
        ];

        return $attrs;
    }
}
