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
        Schema::create('l4_sellers', function (Blueprint $table) {
            $table->id();
            $table->string('telegram_id')->unique()->comment('Telegram user ID');
            $table->string('username')->nullable()->comment('Telegram username');
            $table->string('first_name')->nullable()->comment('User first name');
            $table->string('last_name')->nullable()->comment('User last name');
            $table->enum('status', ['active', 'banned'])->default('active')->comment('Seller status');
            $table->decimal('balance', 10, 2)->default(0)->comment('Current balance');
            $table->integer('total_numbers_sold')->default(0)->comment('Total numbers sold');
            $table->decimal('commission_rate', 5, 2)->default(10.00)->comment('Commission rate percentage');
            $table->timestamp('last_activity')->nullable()->comment('Last activity timestamp');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('telegram_id');
            $table->index('status');
            $table->index('last_activity');
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('l4_sellers');
    }
};