<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerRelatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('customer_relates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('customer_related_id');

            $table->enum('type', ['Soltero(a)', 'Sociedad Conyugal', 'Copropietario'])->default('Soltero(a)');
            $table->enum('partner_type', ['Tradicional', 'Casado con separación de patrimonio'])->nullable();

            $table->integer('part_one')->nullable();
            $table->integer('part_two')->nullable();
            $table->string('document_nro')->nullable();
            $table->string('document')->nullable();

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
        Schema::dropIfExists('customer_relates');
    }
}
