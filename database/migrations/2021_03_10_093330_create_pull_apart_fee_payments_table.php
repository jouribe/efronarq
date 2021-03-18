<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePullApartFeePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pull_apart_fee_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pull_part_fee_id');
            $table->foreign('pull_part_fee_id')->references('id')->on('pull_apart_fees')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('amount')->nullable();
            $table->enum('currency', ['USD', 'PEN'])->default('PEN');
            $table->enum('type', ['Transferencia', 'Efectivo', 'Cheque'])->nullable();
            $table->string('document_nro')->nullable();
            $table->enum('ticket', ['Boleta', 'Factura'])->default('Boleta');
            $table->string('ticket_nro')->nullable();
            $table->string('voucher')->nullable();
            $table->decimal('late_payment')->nullable();
            $table->text('comment')->nullable();
            $table->decimal('exchange_rate')->nullable();
            $table->date('payment_at');
            $table->enum('status', ['Registrado', 'Anulado'])->default('Registrado');
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
        Schema::dropIfExists('pull_apart_fee_payments');
    }
}
