<?php namespace EmberGrep\Http\Transformers;

use EmberGrep\Models\Lesson;
use League\Fractal\TransformerAbstract;

class FreeLesson extends TransformerAbstract
{
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
