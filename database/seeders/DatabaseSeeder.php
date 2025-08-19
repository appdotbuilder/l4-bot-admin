<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\L4Buyer;
use App\Models\L4Seller;
use App\Models\L4Number;
use App\Models\L4Invoice;
use App\Models\L4Payment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create sellers first (needed for numbers)
        $sellers = L4Seller::factory(10)->create([
            'status' => 'active',
        ]);

        // Create some banned sellers
        L4Seller::factory(3)->banned()->create();

        // Create buyers
        $buyers = L4Buyer::factory(25)->create([
            'status' => 'active',
        ]);

        // Create some banned buyers
        L4Buyer::factory(5)->banned()->create();

        // Create numbers (mix of statuses)
        $numbers = collect();
        
        // Available numbers
        $availableNumbers = L4Number::factory(30)->available()->create([
            'seller_id' => $sellers->random()->id,
        ]);
        $numbers = $numbers->merge($availableNumbers);

        // Rented numbers
        $rentedNumbers = L4Number::factory(15)->rented()->create([
            'seller_id' => $sellers->random()->id,
            'buyer_id' => $buyers->random()->id,
        ]);
        $numbers = $numbers->merge($rentedNumbers);

        // Completed numbers
        $completedNumbers = L4Number::factory(40)->completed()->create([
            'seller_id' => $sellers->random()->id,
            'buyer_id' => $buyers->random()->id,
        ]);
        $numbers = $numbers->merge($completedNumbers);

        // Create invoices
        $invoices = collect();
        
        // Pending invoices
        $pendingInvoices = L4Invoice::factory(8)->pending()->create([
            'buyer_id' => $buyers->random()->id,
        ]);
        $invoices = $invoices->merge($pendingInvoices);

        // Paid invoices
        $paidInvoices = L4Invoice::factory(15)->paid()->create([
            'buyer_id' => $buyers->random()->id,
        ]);
        $invoices = $invoices->merge($paidInvoices);

        // Overdue invoices
        $overdueInvoices = L4Invoice::factory(5)->overdue()->create([
            'buyer_id' => $buyers->random()->id,
        ]);
        $invoices = $invoices->merge($overdueInvoices);

        // Create payments
        // Credit payments (top-ups)
        L4Payment::factory(20)->credit()->create([
            'buyer_id' => $buyers->random()->id,
        ]);

        // Debit payments (for invoices)
        foreach ($paidInvoices as $invoice) {
            L4Payment::factory()->debit()->create([
                'buyer_id' => $invoice->buyer_id,
                'invoice_id' => $invoice->id,
                'amount' => $invoice->total_amount,
                'description' => "Payment for invoice {$invoice->invoice_number}",
            ]);
        }

        // Additional debit payments for number rentals
        L4Payment::factory(30)->debit()->create([
            'buyer_id' => $buyers->random()->id,
        ]);
    }
}
