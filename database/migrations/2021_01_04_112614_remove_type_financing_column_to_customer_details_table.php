<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTypeFinancingColumnToCustomerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('customer_details', function (Blueprint $table) {
            $table->dropColumn('type_financing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('customer_details', function (Blueprint $table) {
            $table->enum('type_financing', ['Crédito Hipotecario', 'Financiamiento Directo']);
        });
    }
}
