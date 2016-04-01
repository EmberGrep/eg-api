<?php namespace EmberGrep\Http\Transformers;

use EmberGrep\Models\Lesson;
use Manuel\Transformer\TransformerAbstract;

class FreeLesson extends TransformerAbstract
{
    protected $type = 'free-lessons';

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
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
            'position' => $lesson->position,
        ];

        return $attrs;
    }

    protected function includeTags(Lesson $lesson)
    {
        return $this->collection($lesson->tags, new Tag(), 'lesson_tags');
    }

    protected function includeFiles(Lesson $lesson)
    {
        return $this->collection($lesson->files, new File(), 'lesson_files');
    }

    protected function includeLinks(Lesson $lesson)
    {
        return $this->collection($lesson->links()->orderBy('position')->get(), new Link(), 'lesson_links');
    }
}
