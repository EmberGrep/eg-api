<?php namespace EmberGrep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lesson extends Model
{
    protected $fillable = [
        'title',
        'description',
        'lesson_notes',
        'slug',
        'course_id',
        'next_lesson_id',
        'previous_lesson_id',
        'free',
        'position',
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        $this->attributes['slug'] = Str::slug($value);
    }

    public function video()
    {
        return $this->belongsTo('EmberGrep\\Models\\Video');
    }

    public function tags()
    {
        return $this->belongsToMany('EmberGrep\\Models\\LessonTag');
    }

    public function links()
    {
        return $this->hasMany('EmberGrep\\Models\\LessonLink');
    }

    public function files()
    {
        return $this->hasMany('EmberGrep\\Models\\LessonFile');
    }

    public function course()
    {
        return $this->belongsTo('EmberGrep\\Models\\Course');
    }

    public function getNextLessonAttribute()
    {
        return $this->where(['position' => $this->position + 1, 'course_id' => $this->course_id])->first();
    }

    public function getPreviousLessonAttribute()
    {
        return $this->where(['position' => $this->position - 1, 'course_id' => $this->course_id])->first();
    }

    public function getCourseSlugAttribute()
    {
        if ($this->course) {
            return $this->course->slug;
        }
    }

    public function getNextLessonSlugAttribute()
    {
        if ($this->nextLesson) {
            return $this->nextLesson->slug;
        }
    }

    public function getPreviousLessonSlugAttribute()
    {
        if ($this->previousLesson) {
            return $this->previousLesson->slug;
        }
    }

    public function getLinksProperty()
    {
        return $this->links()->orderBy('position')->get();
    }

    public function getFilesProperty()
    {
        return $this->files()->orderBy('position')->get();
    }
}
