<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->foreignId('period_id')->constrained('periods')->onDelete('cascade'); // assuming periods table
            $table->string('ref_code', 100)->nullable();
            $table->enum('application_type', ['Undergraduate', 'Postgraduate', 'Diploma', 'Certificate']);
            
            $table->foreignId('status_id')->constrained('application_status')->onDelete('restrict');

            $table->timestamps();
        });

        // Add any additional fields as necessary
        // $table->string('additional_field')->nullable(); // Example of an additional field
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
