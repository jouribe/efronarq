<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOfferParkingLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('customer_offer_parking_lots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_offer_id');
            $table->foreign('customer_offer_id')->references('id')->on('customer_offers')->onDelete('cascade');
            $table->unsignedBigInteger('project_parking_lot_id');
            $table->foreign('project_parking_lot_id')->references('id')->on('project_parking_lots')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_offer_parking_lots');
    }
}
