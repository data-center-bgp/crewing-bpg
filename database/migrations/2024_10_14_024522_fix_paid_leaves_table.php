<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('paid_leaves', function (Blueprint $table) {
            DB::statement('ALTER TABLE paid_leaves ALTER COLUMN actual_start_date TYPE DATE USING actual_start_date::DATE');
            $table->date('actual_end_date')->after('actual_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paid_leaves', function (Blueprint $table) {
            $table->string('actual_start_date')->change();
            $table->dropColumn('actual_end_date');
        });
    }
};
