<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePullApartBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pull_apart_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pull_apart_id');
            $table->foreign('pull_apart_id')->references('id')->on('pull_aparts')->onDelete('cascade')->onDelete('cascade');
            $table->boolean('proprietorship')->nullable();
            $table->integer('damages')->nullable();
            $table->string('damages_str')->nullable();
            $table->decimal('unemployment')->nullable();
            $table->string('unemployment_str')->nullable();
            $table->boolean('changes')->nullable();
            $table->boolean('sanitation')->nullable();
            $table->date('delivery_apartment_at')->nullable();
            $table->boolean('delivery_term')->nullable();
            $table->decimal('delivery_term_amount')->nullable();
            $table->string('delivery_term_amount_str')->nullable();
            $table->boolean('additional_term')->nullable();
            $table->boolean('additional_term_at')->nullable();
            $table->decimal('additional_term_penalty')->nullable();
            $table->string('additional_term_penalty_str')->nullable();
            $table->string('footer')->nullable()->default('MINUTA {PROJECT_NAME}/{BUYER_NAME}/{APARTMENT_NRO}/{BUYER_TYPE}/{PAYMENT_TYPE}');
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
        Schema::dropIfExists('pull_apart_bills');
    }
}
