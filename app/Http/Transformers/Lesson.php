<?php namespace EmberGrep\Http\Transformers;

use EmberGrep\Models\Lesson as LessonModel;
use Manuel\Transformer\TransformerAbstract;

use Manuel\Resource\Item;

class Lesson extends TransformerAbstract
{
    protected $type = 'lessons';

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
     * @param LessonModel $lesson
     * @return array
     */
    public function transform(LessonModel $lesson)
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
