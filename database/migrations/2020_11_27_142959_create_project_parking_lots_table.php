<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectParkingLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('project_parking_lots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string('floor');
            $table->string('parking_lot');
            $table->decimal('roofed_area', 10);
            $table->decimal('free_area', 10);
            $table->enum('type', ['Simple', 'Doble']);
            $table->enum('availability', ['Disponible', 'Reservado', 'Separado', 'Vendido']);
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('project_addresses')->onDelete('cascade');
            $table->boolean('discount')->default(false);
            $table->boolean('closet')->default(false);
            $table->string('blueprint')->nullable();
            $table->decimal('price', 20)->nullable();
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
        Schema::dropIfExists('project_parking_lots');
    }
}
