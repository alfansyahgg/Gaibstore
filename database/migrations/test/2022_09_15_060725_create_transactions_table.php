<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_key')->unique();
            $table->string('payment_type');
            $table->decimal('total_price', 10, 0)->nullable();
            $table->string('status')->nullable();
            $table->string('bank')->nullable();
            $table->string('va_number')->nullable();
            $table->string('fraud_status')->nullable();
            $table->string('bca_va_number')->nullable();
            $table->string('permata_va_number')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('bill_key')->nullable();
            $table->string('biller_code')->nullable();
            $table->string('payment_code')->nullable();
            $table->string('status_code')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_status')->nullable();
            $table->timestamp('transaction_time')->nullable();
            $table->timestamp('settlement_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};