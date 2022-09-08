<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuizStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_student', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quiz_id')->unsigned()->index()->nullable();
            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('student_id')->unsigned()->index()->nullable();
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('created_by')->unsigned()->index()->nullable();
            $table->bigInteger('updated_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_student');
    }
}
