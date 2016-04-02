<?php namespace EmberGrep\Http\Transformers;

use EmberGrep\Models\Lesson;
use Manuel\Transformer\TransformerAbstract;

use Manuel\Resource\Item;

class FreeLesson extends TransformerAbstract
{
    protected $type = 'free-lessons';

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $includedResources = [
        'video',
        // 'links',
        // 'tags',
        // 'files',
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

    public function includeVideo(Lesson $lesson)
    {
        if ($lesson->video) {
            return new Item($lesson->video, new Video());
        }

        return null;
    }
}
