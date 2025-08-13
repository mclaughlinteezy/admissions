<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantSubjectsTable extends Migration
{
    public function up()
    {
        Schema::create('applicant_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_record_id')->constrained('applicant_academic_records')->onDelete('cascade');
            $table->string('subject_name', 100);
            $table->string('grade', 10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_subjects');
    }
}
