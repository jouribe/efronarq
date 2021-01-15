<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('customer_type', ['Persona Natural', 'Persona Jurídica'])->default('Persona Natural');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->string('position')->nullable();
            $table->boolean('single')->default(true);
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('customer_type');
            $table->dropForeign('customers_company_id_foreign');
            $table->dropColumn('company_id');
            $table->dropColumn('position');
            $table->dropColumn('single');
            $table->dropColumn('address');
        });
    }
}
