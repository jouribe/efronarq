<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('project_apartment_id');
            $table->foreign('project_apartment_id')->references('id')->on('project_apartments')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('origin_id');
            $table->foreign('origin_id')->references('id')->on('origins')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('interested')->default(false);
            $table->integer('discount')->default(0);
            $table->enum('status', ['Visita', 'Separación', 'Cotización'])->default('Visita');
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
        Schema::dropIfExists('visits');
    }
}
