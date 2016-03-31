<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use EmberGrep\Models\Lesson;
use EmberGrep\Models\Video;

class LessonTest extends TestCase
{
    use DatabaseMigrations;

    public function testCalculatesTime()
    {
        $lesson = Lesson::create(['title' => 'Foo', 'description' => 'Yo', 'position' => 1, 'free' => true]);
        $video = new Video(['time' => 20, 'mp4_sd_url' => 'lorem', 'mp4_hd_url' => 'lorem', 'mp4_source_url' => 'lorem']);

        $video = $lesson->video()->save($video);

        $this->assertEquals($lesson->time, 20);
    }
}
