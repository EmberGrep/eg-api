<?php namespace EmberGrep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Course extends Model
{
    protected $fillable = [
        'name',
        'price',
        'active',
        'release_date',
        'description',
        'description_long',
        'is_published',
        'purchased',
        'coming_soon',
    ];

    protected $dates = ['created_at', 'updated_at', 'release_date'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        $this->attributes['slug'] = Str::slug($value);
    }

    public function getActiveAttribute()
    {
        $currentTime = Carbon::now();

        if (!$this->released_at) {
            return $this->is_published && $currentTime->gte($this->release_date);
        }

        return $this->is_published && $currentTime->gte($this->released_at);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, Purchase::class);
    }

    public function getTimeAttribute()
    {
        return $this->lessons->reduce(function($carry, $lesson) {
            return $carry + $lesson->time;
        }, 0);
    }

    public function hasPurchased()
    {
        $user = \Auth::user();

        if ($user) {
            return $this->purchases()->join('users', 'users.id', '=', 'purchases.user_id')
                ->where('users.id', $user->id)->count() === 1;
        }
    }
}
