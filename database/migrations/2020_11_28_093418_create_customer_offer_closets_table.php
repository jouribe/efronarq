<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOfferClosetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('customer_offer_closets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_offer_id');
            $table->foreign('customer_offer_id')->references('id')->on('customer_offers')->onDelete('cascade');
            $table->unsignedBigInteger('project_closet_id');
            $table->foreign('project_closet_id')->references('id')->on('project_closets')->onDelete('cascade');
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
        Schema::dropIfExists('customer_offer_closets');
    }
}
