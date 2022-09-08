<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuizQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quiz_id')->unsigned()->index()->nullable();
            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyText('question');
            $table->tinyText('option1');
            $table->tinyText('option2');
            $table->tinyText('option3');
            $table->tinyText('option4');
            $table->integer('anwer');
            $table->text('other')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
