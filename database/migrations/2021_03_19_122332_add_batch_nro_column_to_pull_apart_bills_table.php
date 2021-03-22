<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBatchNroColumnToPullApartBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('pull_apart_bills', function (Blueprint $table) {
            $table->string('batch_nro')->after('additional_term_penalty_str')->nullable();
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
            $table->dropColumn('batch_nro');
        });
    }
}
