<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTypesTable extends Migration
{
    public function up()
    {
        Schema::create('attendance_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_types');
    }
}
