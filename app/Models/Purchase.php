<?php namespace EmberGrep\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'charge_amount',
        'card_brand',
        'charge_id',
        'notifications',
    ];
}
