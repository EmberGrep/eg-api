<?php namespace EmberGrep\Http\Transformers;

use EmberGrep\Models\Video as VideoModel;
use Manuel\Transformer\TransformerAbstract;

class Video extends TransformerAbstract
{
    protected $type = 'videos';


    protected $relationships = ['lesson' => 'lessons'];

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
            'sd-url' => $video->mp4_sd_url,
            'hd-url' => $video->mp4_hd_url,
        ];
    }

    public function relationshipLesson(VideoModel $video)
    {
        return $video->lesson()->lists('slug')->first();
    }
}
