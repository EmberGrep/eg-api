<?php

use EmberGrep\Models\Course;
use EmberGrep\Models\User;
use EmberGrep\Models\Purchase;
use EmberGrep\Models\Lesson;
use Carbon\Carbon;

class PurchasedCoursesTest extends AcceptanceTestCase
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

    public function setupData($purchaseCourse = true)
    {
        $this->course = Course::create($this->attrs);

        if ($purchaseCourse) {
            $this->purchase = Purchase::create([
                'user_id' => $this->user->id,
                'course_id' => $this->course->id,
                'charge_amount' => 400,
                'card_brand' => 'VISA',
                'charge_id' => 'BARTER',
            ]);
        }
    }

    public function testAllPurchasedCourses()
    {
        $this->setupData();

        $this->call('GET', '/purchased-courses', [], [], [], $this->bearer($this->token));

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [
                [
                    'type' => 'purchased-courses',
                    'id' => 'first-name',
                    'attributes' => [
                        'name' => $this->attrs['name'],
                        'price' => $this->attrs['price'],
                        'time' => 0,
                        'active' => true,
                        'release-date' => $this->attrs['release_date']->toIso8601String(),
                        'description' => $this->attrs['description'],
                        'long-description' => $this->attrs['description_long'],
                        'purchased' => true,
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

    public function testPurchasedCourseHasLessons()
    {
        $this->setupData();

        $lesson = new Lesson(['title' => 'Foo', 'description' => 'Yo', 'position' => 1, 'free' => false]);

        $this->course->lessons()->save($lesson);

        $this->call('GET', '/purchased-courses', [], [], [], $this->bearer($this->token));

        $this->assertResponseOk();

        $this->seeJson([
            'relationships' => [
                'lessons' => [
                    'data' => [
                        ['type' => 'lessons', 'id' => (string) $lesson->slug],
                    ],
                ],
            ],
        ]);
    }
}
