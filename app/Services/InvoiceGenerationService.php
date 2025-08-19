<?php

namespace App\Services;

use App\Models\L4Buyer;
use App\Models\L4Invoice;
use App\Models\L4Number;
use Carbon\Carbon;

class InvoiceGenerationService
{
    /**
     * Generate daily billing invoices for a specific date.
     *
     * @param string $date
     * @return int Number of invoices generated
     */
    public function generateDailyInvoices(string $date): int
    {
        $invoiceDate = Carbon::parse($date);
        $generatedCount = 0;

        // Get all buyers who used numbers on the specified date
        $buyers = L4Buyer::whereHas('numbers', function ($query) use ($invoiceDate) {
            $query->whereDate('rented_at', $invoiceDate->toDateString())
                  ->whereIn('status', ['completed', 'cancelled']);
        })->get();

        foreach ($buyers as $buyer) {
            // Check if invoice already exists for this buyer and date
            $existingInvoice = L4Invoice::where('buyer_id', $buyer->id)
                ->whereDate('invoice_date', $invoiceDate->toDateString())
                ->first();

            if ($existingInvoice) {
                continue;
            }

            // Get numbers used by this buyer on the specified date
            $numbers = L4Number::where('buyer_id', $buyer->id)
                ->whereDate('rented_at', $invoiceDate->toDateString())
                ->whereIn('status', ['completed', 'cancelled'])
                ->get();

            if ($numbers->count() > 0) {
                $totalAmount = $numbers->sum('price');
                $lineItems = $numbers->map(function ($number) {
                    return [
                        'phone_number' => $number->phone_number,
                        'country' => $number->country_name,
                        'service' => $number->service,
                        'price' => $number->price,
                        'rented_at' => $number->rented_at,
                    ];
                })->toArray();

                L4Invoice::create([
                    'invoice_number' => 'INV-' . $invoiceDate->format('Ymd') . '-' . str_pad((string)$buyer->id, 4, '0', STR_PAD_LEFT),
                    'buyer_id' => $buyer->id,
                    'invoice_date' => $invoiceDate,
                    'total_amount' => $totalAmount,
                    'numbers_count' => $numbers->count(),
                    'description' => "Daily usage invoice for {$invoiceDate->format('F j, Y')}",
                    'line_items' => $lineItems,
                ]);

                $generatedCount++;
            }
        }

        return $generatedCount;
    }
}