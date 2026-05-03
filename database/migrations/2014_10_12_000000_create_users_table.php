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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('role', ['student', 'teacher', 'admin']);
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('semester')->nullable();
            $table->string('subject_yeare')->nullable();
            $table->string('year_student')->default('السنة الاولى');
            $table->string('subject_sep')->nullable();
            $table->string("ratio")->nullable();
            $table->string("father")->nullable();
            $table->string("father_job")->nullable();
            $table->string("mother")->nullable();  
            $table->string("place_and_number_of_registration")->nullable(); 
            $table->string("place_of_birth")->nullable();
            $table->string("place_Get_the_certificate")->nullable();
            $table->string("total")->nullable(); 
            $table->string("religion")->nullable(); 
            $table->string("city")->nullable(); 
            $table->string("gender")->nullable();
            $table->string("language")->nullable();
            $table->string("exam_session")->nullable(); 
            $table->string("teacher")->nullable(); 
            $table->string("family")->nullable();
            $table->string("recruitment_division")->nullable(); 
            $table->integer("national_number")->nullable()->unique();
            $table->date("date_of_birth")->nullable();
            $table->string("mobile_phone_number")->nullable();
            $table->string("landline_number")->nullable(); 
            $table->text("detailed_address")->nullable();
            $table->date("date_of_registration")->nullable(); 
            $table->string('specializations_id')->nullable();
            $table->boolean('is_hidden')->default(false);
            // $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
