<?php

use EmberGrep\Models\Lesson;
use EmberGrep\Models\Video;

class FreeLessonsTest extends AcceptanceTestCase
{
    public function testAllFreeLessons()
    {
        $freeLesson = Lesson::create(['title' => 'Foo', 'description' => 'Yo', 'position' => 1, 'free' => true]);
        Lesson::create(['title' => 'Bar', 'description' => 'Yo', 'position' => 2, 'free' => false]);
        $video = new Video(['time' => 20, 'mp4_sd_url' => 'lorem', 'mp4_hd_url' => 'lorem', 'mp4_source_url' => 'lorem']);
        $freeLesson->video()->save($video);

        $this->call('GET', '/free-lessons');

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [
                [
                    'type' => 'free-lessons',
                    'id' => 'foo',
                    'attributes' => [
                        'title' => 'Foo',
                        'description' => 'Yo',
                        'time' => 20,
                        'lesson-notes' => '',
                    ],
                    'relationships' => [
                        'video' => [
                            'data' => [
                                'type' => 'free-videos',
                                'id' => (string)$video->id,
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testFindFreeLesson()
    {
        Lesson::create(['title' => 'Foo', 'description' => 'Yo', 'position' => 1, 'free' => true]);
        $this->call('GET', '/free-lessons/foo');

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [
                'type' => 'free-lessons',
                'id' => 'foo',
                'attributes' => [
                    'title' => 'Foo',
                    'description' => 'Yo',
                    'time' => 0,
                    'lesson-notes' => '',
                ],
                'relationships' => [],
            ],
        ]);
    }

    public function testErrorFindFreeLessonIsPaid()
    {
        Lesson::create(['title' => 'Foo', 'description' => 'Yo', 'position' => 1, 'free' => false]);
        $this->call('GET', '/free-lessons/foo');

        $this->assertResponseStatus(401);

        $this->seeJson([
            'errors' => [
                [
                    'status' => '401',
                    'title' => 'Paid Lesson',
                    'detail' => 'The selected lesson is paid Lesson.'
                ],
            ],
        ]);
    }

    public function testErrorFindFreeLessonDoesntExist()
    {
        Lesson::create(['title' => 'Foo', 'position' => 1, 'free' => false]);
        $this->call('GET', '/free-lessons/bar');

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
