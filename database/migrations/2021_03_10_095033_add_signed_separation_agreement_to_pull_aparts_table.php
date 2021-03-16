<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignedSeparationAgreementToPullApartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('pull_aparts', function (Blueprint $table) {
            $table->string('signed_separation_agreement')->nullable()->after('separation_agreement_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pull_aparts', function (Blueprint $table) {
            $table->dropColumn('signed_separation_agreement');
        });
    }
}
