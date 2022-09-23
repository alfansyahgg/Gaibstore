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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->string('order_key', 10);
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->string('address', 50)->nullable();
            $table->string('city_id', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('zip_code', 50)->nullable();
            $table->string('shipping_code');
            $table->string('shipping_name');
            $table->string('shipping_origin', 5);
            $table->string('shipping_destination', 5);
            $table->string('shipping_weight', 5);
            $table->string('shipping_service', 30);
            $table->decimal('shipping_cost', 15, 0);
            $table->string('shipping_etd');
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
        Schema::dropIfExists('shippings');
    }
};