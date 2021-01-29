<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePullApartCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pull_apart_comments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pull_apart_id');
            $table->unsignedBigInteger('user_id');

            $table->enum('status', ['Pendiente Aprobación', 'Aprobado', 'Rechazado'])->default('Pendiente Aprobación');
            $table->text('comment')->nullable();

            $table->timestamps();

            $table->foreign('pull_apart_id')->references('id')->on('pull_aparts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pull_apart_comments');
    }
}
