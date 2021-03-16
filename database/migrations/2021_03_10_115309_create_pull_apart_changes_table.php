<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePullApartChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pull_apart_changes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pull_apart_id');
            $table->foreign('pull_apart_id')->references('id')->on('pull_aparts')->onDelete('cascade')->onDelete('cascade');
            $table->string('estimate')->nullable();
            $table->string('blueprint')->nullable();
            $table->decimal('amount')->nullable();
            $table->enum('currency', ['USD', 'PEN'])->default('PEN');
            $table->decimal('exchange')->nullable();
            $table->date('payment_at')->nullable();
            $table->integer('estimate_days')->nullable();
            $table->date('delivery_at')->nullable(); // TODO: esto actualiza la fecha de entrega de la minuta.
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
        Schema::dropIfExists('pull_apart_changes');
    }
}
