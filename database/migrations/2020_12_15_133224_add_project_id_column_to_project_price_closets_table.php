<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectIdColumnToProjectPriceClosetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('project_price_closets', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('project_price_closets', function (Blueprint $table) {
            $table->dropForeign('project_price_closets_project_id_foreign');
            $table->dropColumn('project_id');
        });
    }
}
