<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lessons', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->text('description')->nullable();
			$table->text('lesson_notes')->nullable();
			$table->string('slug');
			$table->integer('course_id')->nullable();
			$table->integer('position');
			$table->integer('video_id')->nullable();
			$table->boolean('free')->default(false);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lessons');
	}

}
