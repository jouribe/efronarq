<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ColumnTypeProjectApartmentTypesChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('project_apartment_types', function (Blueprint $table) {
            $table->decimal('bedroom', 10)->change();
            $table->decimal('bathroom', 10)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('project_apartment_types', function (Blueprint $table) {
            $table->integer('bedroom')->change();
            $table->integer('bathroom')->change();
        });
    }
}
