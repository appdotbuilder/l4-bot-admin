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
        Schema::create('l4_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->unique()->comment('Phone number');
            $table->string('country_code', 5)->comment('Country code');
            $table->string('country_name')->comment('Country name');
            $table->foreignId('seller_id')->constrained('l4_sellers')->onDelete('cascade');
            $table->foreignId('buyer_id')->nullable()->constrained('l4_buyers')->onDelete('set null');
            $table->enum('status', ['available', 'rented', 'completed', 'cancelled', 'expired'])->default('available')->comment('Number status');
            $table->decimal('price', 8, 2)->comment('Rental price');
            $table->string('service')->nullable()->comment('Service for which number is used');
            $table->text('sms_codes')->nullable()->comment('Received SMS codes');
            $table->timestamp('rented_at')->nullable()->comment('When number was rented');
            $table->timestamp('expires_at')->nullable()->comment('When rental expires');
            $table->timestamp('completed_at')->nullable()->comment('When rental completed');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('phone_number');
            $table->index('seller_id');
            $table->index('buyer_id');
            $table->index('status');
            $table->index('country_code');
            $table->index(['status', 'created_at']);
            $table->index(['expires_at', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('l4_numbers');
    }
};