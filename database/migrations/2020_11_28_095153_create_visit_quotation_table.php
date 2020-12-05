<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('visit_quotation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id');
            $table->foreign('visit_id')->references('id')->on('visits')->onDelete('cascade');
            $table->string('file');
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
        Schema::dropIfExists('visit_quotation');
    }
}
