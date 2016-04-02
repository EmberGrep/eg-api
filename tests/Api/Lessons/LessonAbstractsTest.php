<?php

use EmberGrep\Models\Lesson;
use EmberGrep\Models\Video;

class LessonAbstractsTest extends AcceptanceTestCase
{
    public function testAllLessonAbstracts()
    {
        $freeLesson = Lesson::create(['title' => 'Foo', 'description' => 'Yo', 'position' => 1, 'free' => true]);
        Lesson::create(['title' => 'Bar', 'description' => 'Yo', 'position' => 2, 'free' => false]);
        $video = new Video(['time' => 20, 'mp4_sd_url' => 'lorem', 'mp4_hd_url' => 'lorem', 'mp4_source_url' => 'lorem']);
        $freeLesson->video()->save($video);

        $this->call('GET', '/lesson-abstracts');

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [
                [
                    'type' => 'lesson-abstracts',
                    'id' => 'foo',
                    'attributes' => [
                        'title' => 'Foo',
                        'description' => 'Yo',
                        'time' => 20,
                    ],
                ],
                [
                    'type' => 'lesson-abstracts',
                    'id' => 'bar',
                    'attributes' => [
                        'title' => 'Bar',
                        'description' => 'Yo',
                        'time' => 0,
                    ],
                ],
            ],
        ]);
    }

    public function testFindFreeLesson()
    {
        Lesson::create(['title' => 'Foo', 'description' => 'Yo', 'position' => 1, 'free' => true]);
        $this->call('GET', '/lesson-abstracts/foo');

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [
                'type' => 'lesson-abstracts',
                'id' => 'foo',
                'attributes' => [
                    'title' => 'Foo',
                    'description' => 'Yo',
                    'time' => 0,
                ],
            ],
        ]);
    }

    public function testErrorFindFreeLessonDoesntExist()
    {
        Lesson::create(['title' => 'Foo', 'position' => 1, 'free' => false]);
        $this->call('GET', '/lesson-abstracts/bar');

        $this->assertResponseStatus(404);

        $this->seeJson([
            'errors' => [
                [
                    'status' => '404',
                    'title' => 'Not Found',
                    'detail' => 'The requested resource was not found.'
                ],
            ],
        ]);
    }
}
