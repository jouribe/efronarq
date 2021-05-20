<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExchangeColumnToVisitsTable extends Migration
{
    public function up(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->unsignedBigInteger('exchange_id')->after('origin_id')->nullable();
            $table->foreign('exchange_id')->references('id')->on('exchanges');
        });
    }

    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropForeign('exchange_id');
        });
    }
}
