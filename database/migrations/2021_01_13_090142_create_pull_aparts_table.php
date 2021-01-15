<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePullApartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pull_aparts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('visit_id');
            $table->foreign('visit_id')->references('id')->on('visits')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('discount')->default(0);
            $table->enum('buyer_type', ['Soltero(a)', 'Sociedad Conyugal', 'Copropietario', 'Empresa'])->default('Soltero(a)');

            $table->enum('payment_type', ['Directo', 'Hipotecario', 'Mixto'])->default('Directo');

            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade')->onUpdate('cascade');

            $table->decimal('amount')->default(0);
            $table->date('amount_at')->nullable();
            $table->string('milestone')->nullable();

            $table->decimal('fee_balance')->nullable();
            $table->date('fee_balance_at')->nullable();
            $table->string('fee_balance_milestone')->nullable();
            $table->decimal('afp_amount')->nullable();
            $table->date('afp_amount_at')->nullable();
            $table->string('afp_amount_milestone')->nullable();
            $table->decimal('mortgage_credit')->nullable();
            $table->date('mortgage_credit_at')->nullable();
            $table->string('mortgage_credit_milestone')->nullable();

            $table->date('separation_agreement_at')->nullable();
            $table->date('signature_minute_at')->nullable();

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
        Schema::dropIfExists('pull_aparts');
    }
}
