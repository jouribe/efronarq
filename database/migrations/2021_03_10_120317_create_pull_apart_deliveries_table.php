<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePullApartDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pull_apart_deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pull_apart_id');
            $table->foreign('pull_apart_id')->references('id')->on('pull_aparts')->onDelete('cascade')->onDelete('cascade');
            $table->date('delivery_at')->nullable();
            $table->time('delivery_at_time')->nullable();
            $table->string('executive')->nullable();
            $table->string('evidence')->nullable();
            $table->decimal('penalty')->nullable();
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
        Schema::dropIfExists('pull_apart_deliveries');
    }
}
