<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnToPullApartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('pull_aparts', function (Blueprint $table) {
            $table->enum('status', ['Pendiente Aprobación', 'Aprobado', 'Registrado', 'Rechazado'])->default('Registrado');
            $table->text('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pull_aparts', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('comment');
        });
    }
}
