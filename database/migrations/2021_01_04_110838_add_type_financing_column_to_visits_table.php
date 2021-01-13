<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeFinancingColumnToVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->enum('type_financing', ['Financiamiento directo', 'Crédito hipotecario'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn('type_financing');
        });
    }
}
