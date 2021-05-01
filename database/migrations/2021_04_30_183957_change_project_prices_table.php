<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProjectPricesTable extends Migration
{
    public function up(): void
    {
        Schema::table('project_prices', function (Blueprint $table) {
            $table->decimal('free_area', 10)->change();
            $table->decimal('discount_presale', 10)->change();
            $table->decimal('delivery_increment', 10)->change();
            $table->decimal('parking_discount', 10)->change();
        });
    }

    public function down(): void
    {
        Schema::table('project_prices', function (Blueprint $table) {
            //
        });
    }
}
