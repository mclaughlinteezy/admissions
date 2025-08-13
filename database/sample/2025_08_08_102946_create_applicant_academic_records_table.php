<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantAcademicRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('applicant_academic_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->string('institution_name', 255);
            $table->string('academic_board', 255)->nullable();
            $table->string('qualification_type', 100);
            $table->year('year_completed');
            $table->string('document_file_path', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_academic_records');
    }
}
