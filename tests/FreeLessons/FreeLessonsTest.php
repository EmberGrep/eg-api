<?php

use EmberGrep\Models\Lesson;

class FreeLessonsTest extends AcceptanceTestCase
{
    public function testAllFreeLessons()
    {
        Lesson::create(['title' => 'Foo', 'position' => 1, 'free' => true]);
        Lesson::create(['title' => 'Bar', 'position' => 2, 'free' => false]);
        $this->call('GET', '/free-lessons');

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [
                [
                    'type' => 'free-lessons',
                    'id' => 'foo',
                    'attributes' => [
                        'title' => 'Foo',
                        'position' => '1',
                    ],
                ],
            ],
        ]);
    }

    public function testFindFreeLesson()
    {
        Lesson::create(['title' => 'Foo', 'position' => 1, 'free' => true]);
        $this->call('GET', '/free-lessons/foo');

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [
                'type' => 'free-lessons',
                'id' => 'foo',
                'attributes' => [
                    'title' => 'Foo',
                    'position' => '1',
                ],
            ],
        ]);
    }

    public function testErrorFindFreeLessonIsPaid()
    {
        Lesson::create(['title' => 'Foo', 'position' => 1, 'free' => false]);
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
