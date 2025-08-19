<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBuyerRequest;
use App\Http\Requests\UpdateBuyerRequest;
use App\Models\L4Buyer;
use App\Models\L4Number;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BuyerController extends Controller
{
    /**
     * Display a listing of the buyers.
     */
    public function index(Request $request)
    {
        $query = L4Buyer::with(['numbers', 'invoices']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name, username, or telegram ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('telegram_id', 'like', "%{$search}%");
            });
        }

        $buyers = $query->latest()->paginate(20);

        return Inertia::render('admin/buyers/index', [
            'buyers' => $buyers,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new buyer.
     */
    public function create()
    {
        return Inertia::render('admin/buyers/create');
    }

    /**
     * Store a newly created buyer.
     */
    public function store(StoreBuyerRequest $request)
    {
        $buyer = L4Buyer::create($request->validated());

        return redirect()->route('buyers.show', $buyer)
            ->with('success', 'Buyer created successfully.');
    }

    /**
     * Display the specified buyer.
     */
    public function show(L4Buyer $buyer)
    {
        $buyer->load([
            'numbers' => function ($query) {
                $query->with('seller')->latest();
            },
            'invoices' => function ($query) {
                $query->latest();
            },
            'payments' => function ($query) {
                $query->latest();
            }
        ]);

        return Inertia::render('admin/buyers/show', [
            'buyer' => $buyer,
        ]);
    }

    /**
     * Show the form for editing the buyer.
     */
    public function edit(L4Buyer $buyer)
    {
        return Inertia::render('admin/buyers/edit', [
            'buyer' => $buyer,
        ]);
    }

    /**
     * Update the specified buyer.
     */
    public function update(UpdateBuyerRequest $request, L4Buyer $buyer)
    {
        $buyer->update($request->validated());

        return redirect()->route('buyers.show', $buyer)
            ->with('success', 'Buyer updated successfully.');
    }

    /**
     * Remove the specified buyer.
     */
    public function destroy(L4Buyer $buyer)
    {
        $buyer->delete();

        return redirect()->route('buyers.index')
            ->with('success', 'Buyer deleted successfully.');
    }


}