<?php

use EmberGrep\Models\Course;
use EmberGrep\Models\Lesson;
use Carbon\Carbon;

class CourseAbstractssTest extends AcceptanceTestCase
{
    public function __construct()
    {
        $this->attrs = [
            'name' => 'First Name',
            'price' => 200,
            'release_date' => Carbon::now()->subDay(),
            'description' => 'lorem pixum',
            'is_published' => true,
            'description_long' => 'Lorem ipsum dolor sit amet',
            'coming_soon' => false,
        ];
    }

    public function testAllCourseAbstractss()
    {
        Course::create($this->attrs);

        $this->call('GET', '/course-abstracts');

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [
                [
                    'type' => 'course-abstracts',
                    'id' => 'first-name',
                    'attributes' => [
                        'name' => $this->attrs['name'],
                        'price' => $this->attrs['price'],
                        'time' => 0,
                        'active' => true,
                        'release-date' => $this->attrs['release_date']->toIso8601String(),
                        'description' => $this->attrs['description'],
                        'long-description' => $this->attrs['description_long'],
                        'purchased' => false,
                        'coming-soon' => $this->attrs['coming_soon'],
                    ],
                    'relationships' => [
                        'lessons' => [
                            'data' => [],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testHasLessons()
    {
        $lesson = new Lesson(['title' => 'Foo', 'description' => 'Yo', 'position' => 1, 'free' => false]);
        $course = Course::create($this->attrs);
        $course->lessons()->save($lesson);

        $this->call('GET', '/course-abstracts');

        $this->assertResponseOk();

        $this->seeJson([
            'relationships' => [
                'lessons' => [
                    'data' => [
                        ['type' => 'lesson-abstracts', 'id' => (string) $lesson->slug],
                    ],
                ],
            ],
        ]);
    }

    public function testFindCourseAbstracts()
    {
        Course::create($this->attrs);

        $this->call('GET', '/course-abstracts/first-name');

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [
                'type' => 'course-abstracts',
                'id' => 'first-name',
                'attributes' => [
                    'name' => $this->attrs['name'],
                    'price' => $this->attrs['price'],
                    'time' => 0,
                    'active' => true,
                    'release-date' => $this->attrs['release_date']->toIso8601String(),
                    'description' => $this->attrs['description'],
                    'long-description' => $this->attrs['description_long'],
                    'purchased' => false,
                    'coming-soon' => $this->attrs['coming_soon'],
                ],
                'relationships' => [
                    'lessons' => [
                        'data' => [],
                    ],
                ],
            ],
        ]);
    }

    public function testErrorFindCourseAbstractsDoesntExist()
    {
        $this->call('GET', '/course-abstracts/bar');

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
