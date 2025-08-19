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
        Schema::create('l4_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('l4_buyers')->onDelete('cascade');
            $table->foreignId('invoice_id')->nullable()->constrained('l4_invoices')->onDelete('set null');
            $table->decimal('amount', 10, 2)->comment('Payment amount');
            $table->enum('type', ['credit', 'debit'])->comment('Payment type');
            $table->string('method')->nullable()->comment('Payment method');
            $table->string('transaction_id')->nullable()->comment('External transaction ID');
            $table->text('description')->comment('Payment description');
            $table->json('metadata')->nullable()->comment('Additional payment metadata');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('buyer_id');
            $table->index('invoice_id');
            $table->index('type');
            $table->index('transaction_id');
            $table->index(['buyer_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('l4_payments');
    }
};