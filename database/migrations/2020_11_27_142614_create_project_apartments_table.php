<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('project_apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->unsignedBigInteger('apartment_type_id');
            $table->foreign('apartment_type_id')->references('id')->on('project_apartment_types')->onDelete('cascade');
            $table->enum('availability', ['Disponible', 'Reservado', 'Separado', 'Vendido']);
            $table->string('name');
            $table->integer('start_floor');
            $table->integer('end_floor');
            $table->integer('parking_lots');
            $table->integer('closets');
            $table->integer('order');
            $table->decimal('price', 20)->nullable();
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
        Schema::dropIfExists('project_apartments');
    }
}
