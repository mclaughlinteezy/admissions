<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('applicant_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->enum('document_type', ['Birth Certificate', 'National ID', 'Passport', 'Other']);
            $table->string('file_path', 255);
            $table->timestamp('uploaded_at')->useCurrent();
            $table->boolean('verified')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_documents');
    }
}
