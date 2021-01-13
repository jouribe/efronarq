<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitClosetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('visit_closets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id');
            $table->foreign('visit_id')->references('id')->on('visits')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('project_closet_id');
            $table->foreign('project_closet_id')->references('id')->on('project_closets')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('visit_closets');
    }
}
