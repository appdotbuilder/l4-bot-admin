<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\L4Invoice;
use App\Models\L4Buyer;
use App\Services\InvoiceGenerationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     */
    public function index(Request $request)
    {
        $query = L4Invoice::with(['buyer', 'payments']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('invoice_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('invoice_date', '<=', $request->date_to);
        }

        $invoices = $query->latest('invoice_date')->paginate(20);

        return Inertia::render('admin/invoices/index', [
            'invoices' => $invoices,
            'filters' => $request->only(['status', 'date_from', 'date_to']),
        ]);
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $buyers = L4Buyer::active()->get();

        return Inertia::render('admin/invoices/create', [
            'buyers' => $buyers,
        ]);
    }

    /**
     * Store a newly created invoice.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $invoice = L4Invoice::create($request->validated());

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified invoice.
     */
    public function show(L4Invoice $invoice)
    {
        $invoice->load(['buyer', 'payments']);

        return Inertia::render('admin/invoices/show', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Show the form for editing the invoice.
     */
    public function edit(L4Invoice $invoice)
    {
        $buyers = L4Buyer::active()->get();

        return Inertia::render('admin/invoices/edit', [
            'invoice' => $invoice,
            'buyers' => $buyers,
        ]);
    }

    /**
     * Update the specified invoice.
     */
    public function update(UpdateInvoiceRequest $request, L4Invoice $invoice)
    {
        $invoice->update($request->validated());

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified invoice.
     */
    public function destroy(L4Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }


}