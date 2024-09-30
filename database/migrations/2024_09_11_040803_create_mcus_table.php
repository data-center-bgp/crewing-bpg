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
        Schema::create('mcus', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('crew_id')->constrained()->onDelete('cascade');
            $table->string('mcu_document');
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->string('certificate_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcus');
    }
};
