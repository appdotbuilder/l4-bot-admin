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
        Schema::create('l4_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique()->comment('Unique invoice number');
            $table->foreignId('buyer_id')->constrained('l4_buyers')->onDelete('cascade');
            $table->date('invoice_date')->comment('Invoice date');
            $table->decimal('total_amount', 10, 2)->comment('Total invoice amount');
            $table->integer('numbers_count')->comment('Number of phone numbers used');
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending')->comment('Invoice status');
            $table->timestamp('paid_at')->nullable()->comment('When invoice was paid');
            $table->text('description')->nullable()->comment('Invoice description');
            $table->json('line_items')->nullable()->comment('Detailed line items');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('invoice_number');
            $table->index('buyer_id');
            $table->index('invoice_date');
            $table->index('status');
            $table->index(['buyer_id', 'invoice_date']);
            $table->index(['status', 'invoice_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('l4_invoices');
    }
};