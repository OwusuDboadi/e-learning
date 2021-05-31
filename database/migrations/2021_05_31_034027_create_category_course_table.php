<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_course', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('category_id')->index();
             $table->unsignedBigInteger('course_id')->index();
             $table->foreign('category_id')->references('id')->on('categories');
             $table->foreign('course_id')->references('id')->on('courses');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_course');
    }
}
