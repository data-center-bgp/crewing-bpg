<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('certificate_document')->before('certificate_status');
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->string('transfer_document')->before('transfer_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('certificate_document');
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->dropColumn('transfer_document');
        });
    }
};
