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
    public function up()
    {
        Schema::create('pull_aparts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('visit_id');
            $table->foreign('visit_id')->references('id')->on('visits')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('discount')->default(0);
            $table->enum('buyer_type', ['Soltero(a)', 'Sociedad Conyugal', 'Copropietario', 'Empresa'])->default('Soltero(a)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pull_aparts');
    }
}
