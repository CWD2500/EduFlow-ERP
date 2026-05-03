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
        Schema::create('exame_manages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject_id');
            $table->string('student_id');
            $table->unsignedBigInteger('student_number_id')->nullable();
            $table->string('specializations_id');
            $table->string('academic_year'); # السنة الأكاديمية
            $table->string('Supplementary_course')->nullable();# دورة تكميلية
            $table->string('degree_n'); # درجة ن 
            $table->string('degree_p');  # درجة ع
            $table->string('exam_n'); # امتحان ن
            $table->string('exam_p'); # امتحان ع 
            
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exame_manages');
    }
};
