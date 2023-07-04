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
    Schema::table('student_practice_places', function (Blueprint $table) {
            $table->unsignedBigInteger('teacher_id')->nullable()->after('student_id');
            $table->foreign('teacher_id')->on('teachers')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_practice_places', function (Blueprint $table) {
            $table->dropColumn('teacher_id');
        });
    }
};
