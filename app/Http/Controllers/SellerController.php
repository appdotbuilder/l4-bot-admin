<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSellerRequest;
use App\Http\Requests\UpdateSellerRequest;
use App\Models\L4Seller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SellerController extends Controller
{
    /**
     * Display a listing of the sellers.
     */
    public function index(Request $request)
    {
        $query = L4Seller::with('numbers');

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

        $sellers = $query->latest()->paginate(20);

        return Inertia::render('admin/sellers/index', [
            'sellers' => $sellers,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new seller.
     */
    public function create()
    {
        return Inertia::render('admin/sellers/create');
    }

    /**
     * Store a newly created seller.
     */
    public function store(StoreSellerRequest $request)
    {
        $seller = L4Seller::create($request->validated());

        return redirect()->route('sellers.show', $seller)
            ->with('success', 'Seller created successfully.');
    }

    /**
     * Display the specified seller.
     */
    public function show(L4Seller $seller)
    {
        $seller->load([
            'numbers' => function ($query) {
                $query->with('buyer')->latest();
            }
        ]);

        return Inertia::render('admin/sellers/show', [
            'seller' => $seller,
        ]);
    }

    /**
     * Show the form for editing the seller.
     */
    public function edit(L4Seller $seller)
    {
        return Inertia::render('admin/sellers/edit', [
            'seller' => $seller,
        ]);
    }

    /**
     * Update the specified seller.
     */
    public function update(UpdateSellerRequest $request, L4Seller $seller)
    {
        $seller->update($request->validated());

        return redirect()->route('sellers.show', $seller)
            ->with('success', 'Seller updated successfully.');
    }

    /**
     * Remove the specified seller.
     */
    public function destroy(L4Seller $seller)
    {
        $seller->delete();

        return redirect()->route('sellers.index')
            ->with('success', 'Seller deleted successfully.');
    }


}