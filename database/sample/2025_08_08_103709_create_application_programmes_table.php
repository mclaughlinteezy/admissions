<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationProgrammesTable extends Migration
{
    public function up()
    {
        Schema::create('application_programmes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('programme_id')->constrained('programmes')->onDelete('restrict'); // assuming programmes table
            $table->foreignId('attendance_type_id')->constrained('attendance_types')->onDelete('restrict'); // assuming attendance_types table
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('application_programmes');
    }
}
