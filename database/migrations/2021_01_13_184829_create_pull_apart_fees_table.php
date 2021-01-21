<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePullApartFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pull_apart_fees', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pull_apart_id');
            $table->foreign('pull_apart_id')->references('id')->on('pull_aparts')->onDelete('cascade')->onUpdate('cascade');

            $table->decimal('fee');
            $table->date('fee_at');
            $table->string('milestone')->nullable();
            $table->enum('type', ['Monto Separación', 'Saldo Cuota Inicial', 'AFP', 'Crédito Hipotecario', 'Cuota']);
            $table->boolean('pay')->default(false);
            $table->date('payment_at')->nullable();
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
        Schema::dropIfExists('pull_apart_fees');
    }
}
