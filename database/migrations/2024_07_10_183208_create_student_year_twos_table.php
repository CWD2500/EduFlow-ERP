<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_year_twos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_id')->nullable();// أو student_id حسب هيكل التطبيق لديك
            $table->string('student_name')->nullable();// أو student_id حسب هيكل التطبيق لديك
            $table->string('specializations_id');
            $table->string('year_one_student');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_year_twos');
    }
};
