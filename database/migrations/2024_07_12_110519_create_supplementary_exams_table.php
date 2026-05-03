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
        Schema::create('supplementary_exams', function (Blueprint $table) {
            $table->bigIncrements('id');
      
            $table->string('student_id')->nullable(); // يجب أن تكون مطابقة لهيكل student_id في نموذج الطالب الخاص بك
            $table->string('student_name')->nullable(); // حقل لاسم الطالب
            $table->string('specializations_id')->nullable(); // معرّف التخصص
            $table->string('exam_id')->nullable();   // معرّف الامتحان أو رقمه
            $table->timestamps(); // حقول التاريخ والوقت المعيارية
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplementary_exams');
    }
};
