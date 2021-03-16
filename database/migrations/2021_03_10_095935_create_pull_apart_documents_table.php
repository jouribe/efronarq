<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePullApartDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pull_apart_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pull_apart_id');
            $table->foreign('pull_apart_id')->references('id')->on('pull_aparts')->onDelete('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade')->onDelete('cascade');
            $table->date('signed_at')->nullable();
            $table->string('observation')->nullable();
            $table->boolean('approve')->default(false);
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
        Schema::dropIfExists('pull_apart_documents');
    }
}
