<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->text('description')->nullable();
			$table->text('description_long')->nullable();
			$table->date('release_date')->nullable();
			$table->integer('price');
            $table->boolean('is_published')->default(false);
            $table->boolean('coming_soon')->default(false);
            $table->timestamp('released_at')->nullable();
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
		Schema::drop('courses');
    }
}
