<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('application_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->enum('payment_type', ['Mobile Money', 'Bank Deposit', 'Credit Card', 'Cash', 'Other']);
            $table->decimal('amount', 10, 2);
            $table->string('reference', 100);
            $table->timestamp('payment_date')->useCurrent();
            $table->boolean('verified')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('application_payments');
    }
}
