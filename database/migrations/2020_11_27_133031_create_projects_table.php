<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->longText('description')->nullable();
            $table->text('legal')->nullable();
            $table->enum('status', ['Preregistrado', 'Preventa', 'En construcción', 'Entrega', 'Finalizado'])->default('Preregistrado');
            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
}
