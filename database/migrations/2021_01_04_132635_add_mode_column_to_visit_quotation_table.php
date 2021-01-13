<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModeColumnToVisitQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('visit_quotation', function (Blueprint $table) {
            $table->string('mode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('visit_quotation', function (Blueprint $table) {
            $table->dropColumn('mode');
        });
    }
}
