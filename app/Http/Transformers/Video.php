<?php namespace EmberGrep\Http\Transformers;

use EmberGrep\Models\Video as VideoModel;
use Manuel\Transformer\TransformerAbstract;

class Video extends TransformerAbstract
{
    protected $type = 'videos';

    /**
     * Transform only desired properties for API
     *
     * @param VideoModel $video
     * @return array
     */
    public function transform(VideoModel $video)
    {
        return [
            'id'      => (string)$video->id,
            'title' => $video->title,
            'time' => (int) $video->time,
            'description' => $video->description,
        ];
    }
}
