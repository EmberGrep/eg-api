<?php  namespace EmberGrep\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'time',
        'mp4_sd_url',
        'mp4_hd_url',
        'mp4_source_url',
    ];
}
