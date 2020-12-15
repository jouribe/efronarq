<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPriceApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('project_price_apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_apartment_type_id');
            $table->foreign('project_apartment_type_id')->references('id')->on('project_apartment_types')->onDelete('cascade');
            $table->integer('start_floor');
            $table->integer('end_floor');
            $table->decimal('price_area', 10);
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
        Schema::dropIfExists('project_price_apartments');
    }
}
