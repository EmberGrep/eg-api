<?php namespace EmberGrep\Http\Transformers;

use EmberGrep\Models\Video as VideoModel;
use Manuel\Transformer\TransformerAbstract;

class FreeVideo extends TransformerAbstract
{
    protected $type = 'free-videos';

    protected $relationships = ['lesson' => 'free-lessons'];

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
            'time' => (int) $video->time,
            'mp4_sd_url' => $video->mp4_sd_url,
            'mp4_hd_url' => $video->mp4_hd_url,
        ];
    }

    public function relationshipLesson(VideoModel $video)
    {
        return $video->lesson()->lists('slug')->first();
    }
}
