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
        Schema::create('crews', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vessel_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->bigInteger('nik');
            $table->string('birthplace');
            $table->date('birthdate');
            $table->bigInteger('phone_number');
            $table->string('address');
            $table->bigInteger('npwp');
            $table->string('bank_name');
            $table->bigInteger('bank_number');
            $table->string('bank_account_name');
            $table->string('marital_status');
            $table->string('title');
            $table->string('sign_on');
            $table->string('degree');
            $table->string('graduation_year');
            $table->bigInteger('seafarer_book_number');
            $table->bigInteger('seafarer_code');
            $table->date('monsterol_issue_date');
            $table->date('monsterol_expiry_date');
            $table->string('crew_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crews');
    }
};
