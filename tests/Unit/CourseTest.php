<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use EmberGrep\Models\Course;
use EmberGrep\Models\User;
use EmberGrep\Models\Lesson;
use EmberGrep\Models\Video;
use EmberGrep\Models\Purchase;
use Carbon\Carbon;

class CourseTest extends TestCase
{
    use DatabaseMigrations;

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

    public function testCalculatesTime()
    {
        $lesson = new Lesson(['title' => 'Foo', 'description' => 'Yo', 'position' => 1, 'free' => true]);
        $video = new Video(['time' => 20, 'mp4_sd_url' => 'lorem', 'mp4_hd_url' => 'lorem', 'mp4_source_url' => 'lorem']);
        $course = Course::create($this->attrs);

        $course->lessons()->save($lesson);
        $lesson->video()->save($video);

        $lessonTwo = new Lesson(['title' => 'Foo', 'description' => 'Yo', 'position' => 2, 'free' => true]);
        $videoTwo = new Video(['time' => 60, 'mp4_sd_url' => 'lorem', 'mp4_hd_url' => 'lorem', 'mp4_source_url' => 'lorem']);

        $course->lessons()->save($lessonTwo);
        $lessonTwo->video()->save($videoTwo);

        $this->assertEquals($course->time, 80);
    }

    public function testCourseIsPurchased()
    {
        $course = Course::create($this->attrs);
        $userProperties = ['email' => 'admin@example.com', 'password' => bcrypt('password')];
        $user = User::create($userProperties);

        $purchase = Purchase::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'charge_amount' => 400,
            'card_brand' => 'VISA',
            'charge_id' => 'BARTER',
        ]);

        Auth::login($user);

        $this->assertEquals($course->hasPurchased(), true);
    }
}
