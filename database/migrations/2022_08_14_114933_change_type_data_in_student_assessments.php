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
        Schema::table('student_assessments', function (Blueprint $table) {
            $table->integer('company_score')->nullable()->change();
            $table->integer('teacher_score')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_assessments', function (Blueprint $table) {
            $table->integer('company_score')->default(0)->change();
            $table->integer('teacher_score')->default(0)->change();
        });
    }
};
