<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectApartmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('project_apartment_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string('type_name');
            $table->decimal('roofed area', 10, 2);
            $table->decimal('free area', 10, 2);
            $table->integer('bedroom');
            $table->integer('bathroom');
            $table->string('vista')->nullable();
            $table->string('blueprint')->nullable();
            $table->boolean('service_room')->default(false);
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
        Schema::dropIfExists('project_apartment_types');
    }
}
