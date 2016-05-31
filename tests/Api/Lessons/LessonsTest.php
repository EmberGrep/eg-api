<?php

use Carbon\Carbon;
use EmberGrep\Models\Course;
use EmberGrep\Models\User;
use EmberGrep\Models\Lesson;
use EmberGrep\Models\Purchase;
use EmberGrep\Models\Video;

class LessonsTest extends AcceptanceTestCase
{
    protected $userAttrs;
    protected $courseAttrs;
    protected $lessonOneAttrs;
    protected $lessonTwoAttrs;

    protected $user;
    protected $token;
    protected $course;
    protected $lessonOne;
    protected $lessonTwo;

    public function __construct()
    {
        $this->courseAttrs = [
            'name' => 'First Name',
            'price' => 200,
            'release_date' => Carbon::now()->subDay(),
            'description' => 'lorem pixum',
            'is_published' => true,
            'description_long' => 'Lorem ipsum dolor sit amet',
            'coming_soon' => false,
        ];

        $this->lessonOneAttrs = ['title' => 'Foo', 'description' => 'Yo', 'position' => 1];
        $this->lessonTwoAttrs = ['title' => 'Bar', 'description' => 'Yo', 'position' => 2];
        $this->lessonThreeAttrs = ['title' => 'Nope', 'description' => 'Yo', 'position' => 1];
    }

    public function setUp()
    {
        parent::setUp();
        $this->userAttrs = ['email' => 'admin@example.com', 'password' => bcrypt('password')];
        $this->user = User::create($this->userAttrs);
        $this->token = JWTAuth::fromUser($this->user);

        $this->course = Course::create($this->courseAttrs);
        $this->lessonOne = new Lesson($this->lessonOneAttrs);
        $this->lessonTwo = new Lesson($this->lessonTwoAttrs);
        $this->lessonThree = Lesson::create($this->lessonThreeAttrs);
        $this->course->lessons()->save($this->lessonOne);
        $this->course->lessons()->save($this->lessonTwo);
        $video = new Video(['time' => 20, 'mp4_sd_url' => 'lorem', 'mp4_hd_url' => 'lorem', 'mp4_source_url' => 'lorem']);
        $this->lessonOne->video()->save($video);
    }

    public function purchaseCourse()
    {
        $this->purchase = Purchase::create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'charge_amount' => 400,
            'card_brand' => 'VISA',
            'charge_id' => 'BARTER',
        ]);
    }

    public function testNoUnpurchasedLessons()
    {
        $this->call('GET', '/lessons', [], [], [], $this->bearer($this->token));

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [],
        ]);
    }

    public function testOnlyPurchasedLessons()
    {
        $this->purchaseCourse();
        $this->call('GET', '/lessons', [], [], [], $this->bearer($this->token));

        $this->assertResponseOk();

        $this->seeJson([
            'data' => [
                [
                    'type' => 'lessons',
                    'id' => 'foo',
                    'attributes' => [
                        'title' => 'Foo',
                        'description' => 'Yo',
                        'time' => 20,
                    ],
                ],
                [
                    'type' => 'lessons',
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

//    public function testFindLesson()
//    {
//        $this->call('GET', '/lessons/foo');
//
//        $this->assertResponseOk();
//
//        $this->seeJson([
//            'data' => [
//                'type' => 'lessons',
//                'id' => 'foo',
//                'attributes' => [
//                    'title' => 'Foo',
//                    'description' => 'Yo',
//                    'time' => 0,
//                ],
//            ],
//        ]);
//    }
//
//    public function testErrorFindLessonDoesntExist()
//    {
//        Lesson::create(['title' => 'Foo', 'position' => 1]);
//        $this->call('GET', '/lessons/bar');
//
//        $this->assertResponseStatus(404);
//
//        $this->seeJson([
//            'errors' => [
//                [
//                    'status' => '404',
//                    'title' => 'Not Found',
//                    'detail' => 'The requested resource was not found.'
//                ],
//            ],
//        ]);
//    }
}
