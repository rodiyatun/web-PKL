<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_aspect_id');
            $table->unsignedBigInteger('student_id');
            $table->text('assessment')->nullable();
            $table->integer("company_score")->default(0);
            $table->integer('teacher_score')->default(0);
            $table->timestamps();
            $table->foreign('assessment_aspect_id')->references('id')->on('assessment_aspects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_assessments');
    }
};
