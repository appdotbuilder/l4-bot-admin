<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\InvoiceGenerationService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InvoiceGenerationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private InvoiceGenerationService $invoiceGenerationService
    ) {}

    /**
     * Handle invoice generation actions.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'action' => 'required|in:generate_daily_invoices',
            'date' => 'required|date',
        ]);

        if ($request->action === 'generate_daily_invoices') {
            $date = Carbon::parse($request->date);
            $generatedCount = $this->invoiceGenerationService->generateDailyInvoices($request->date);

            return back()->with('success', "Generated {$generatedCount} invoices for {$date->format('F j, Y')}.");
        }

        return back()->with('error', 'Invalid action.');
    }
}