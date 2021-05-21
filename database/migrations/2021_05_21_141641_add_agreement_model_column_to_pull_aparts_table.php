<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgreementModelColumnToPullApartsTable extends Migration
{
    public function up(): void
    {
        Schema::table('pull_aparts', function (Blueprint $table) {
            $table->enum('agreement_model', ['Modelo A', 'Modelo B'])->after('status')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pull_aparts', function (Blueprint $table) {
            $table->dropColumn('agreement_model');
        });
    }
}
