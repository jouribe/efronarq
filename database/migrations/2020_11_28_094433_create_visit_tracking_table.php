<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('visit_tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id');
            $table->foreign('visit_id')->references('id')->on('visits')->onDelete('cascade');
            $table->date('action_at');
            $table->enum('action', ['Llamar al cliente', 'Enviar correo', 'Visitar', 'Cotizar', 'Cambios en la condición de venta']);
            $table->text('comments');
            $table->enum('status', ['Pendiente', 'Finalizado'])->default('Pendiente');
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
        Schema::dropIfExists('visit_tracking');
    }
}
