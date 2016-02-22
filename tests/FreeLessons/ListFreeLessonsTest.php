<?php

use EmberGrep\Models\Lesson;

class ListFreeLessonsTest extends AcceptanceTestCase
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
}
