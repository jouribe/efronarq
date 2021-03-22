<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMontanteStrColumnToPullApartBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pull_apart_bills', function (Blueprint $table) {
            $table->string('montante_str')->after('montante')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pull_apart_bills', function (Blueprint $table) {
            $table->dropColumn('montante_str');
        });
    }
}
