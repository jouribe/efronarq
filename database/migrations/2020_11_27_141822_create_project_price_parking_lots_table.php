<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPriceParkingLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('project_price_parking_lots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_price_id');
            $table->foreign('project_price_id')->references('id')->on('project_prices')->onDelete('cascade');
            $table->unsignedBigInteger('project_apartment_type_id');
            $table->foreign('project_apartment_type_id')->references('id')->on('project_apartment_types')->onDelete('cascade');
            $table->string('floor');
            $table->enum('type', ['Simple', 'Doble']);
            $table->decimal('price', 10, 2);
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
        Schema::dropIfExists('project_price_parking_lots');
    }
}
