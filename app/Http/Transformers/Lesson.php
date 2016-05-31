<?php namespace EmberGrep\Http\Transformers;

use EmberGrep\Models\Lesson as LessonModel;
use Manuel\Transformer\TransformerAbstract;

use Manuel\Resource\Item;

class Lesson extends TransformerAbstract
{
    protected $type = 'lessons';

    /**
     * List of resources to automatically include ids for
     *
     * @var array
     */
    protected $relationships = [
        'prev-lesson' => 'lessons',
        'next-lesson' => 'lessons',
    ];

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
     * @param LessonModel $lesson
     * @return array
     */
    public function transform(LessonModel $lesson)
    {
        $attrs = [
            'id'      => $lesson->slug,
            'title' => $lesson->title,
            'time' => (int) $lesson->time,
            'description' => (string)$lesson->description,
            'lesson-notes' => (string)$lesson->lesson_notes,
        ];

        return $attrs;
    }

    public function includeVideo(LessonModel $lesson)
    {
        if ($lesson->video) {
            return new Item($lesson->video, new Video());
        }

        return null;
    }

    public function relationshipPrevLesson(LessonModel $lesson)
    {
        $lesson = $lesson->course->lessons()
            ->orderBy('position', 'desc')
            ->where('position', '<', $lesson->position)
            ->limit(1)
            ->lists('slug')
            ->first();

        return $lesson ?: null;
    }

    public function relationshipNextLesson(LessonModel $lesson)
    {
        $lesson = $lesson->course->lessons()
            ->orderBy('position', 'asc')
            ->where('position', '>', $lesson->position)
            ->limit(1)
            ->lists('slug')
            ->first();

        return $lesson ?: null;
    }
}
