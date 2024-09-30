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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('crew_id')->constrained()->onDelete('cascade');
            $table->date('transfer_date');
            $table->string('transfer_type');
            $table->string('vessel_name_before_transferring');
            $table->string('vessel_name_after_transferring');
            $table->string('previous_title');
            $table->string('new_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
