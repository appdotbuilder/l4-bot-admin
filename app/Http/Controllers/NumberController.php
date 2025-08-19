<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNumberRequest;
use App\Http\Requests\UpdateNumberRequest;
use App\Models\L4Number;
use App\Models\L4Seller;
use App\Models\L4Buyer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NumberController extends Controller
{
    /**
     * Display a listing of the numbers.
     */
    public function index(Request $request)
    {
        $query = L4Number::with(['seller', 'buyer']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by country
        if ($request->filled('country')) {
            $query->where('country_code', $request->country);
        }

        // Search by phone number
        if ($request->filled('search')) {
            $query->where('phone_number', 'like', "%{$request->search}%");
        }

        $numbers = $query->latest()->paginate(20);

        // Get unique countries for filter dropdown
        $countries = L4Number::select('country_code', 'country_name')
            ->distinct()
            ->orderBy('country_name')
            ->get();

        return Inertia::render('admin/numbers/index', [
            'numbers' => $numbers,
            'countries' => $countries,
            'filters' => $request->only(['status', 'country', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new number.
     */
    public function create()
    {
        $sellers = L4Seller::active()->get();

        return Inertia::render('admin/numbers/create', [
            'sellers' => $sellers,
        ]);
    }

    /**
     * Store a newly created number.
     */
    public function store(StoreNumberRequest $request)
    {
        $number = L4Number::create($request->validated());

        return redirect()->route('numbers.show', $number)
            ->with('success', 'Number created successfully.');
    }

    /**
     * Display the specified number.
     */
    public function show(L4Number $number)
    {
        $number->load(['seller', 'buyer']);

        return Inertia::render('admin/numbers/show', [
            'number' => $number,
        ]);
    }

    /**
     * Show the form for editing the number.
     */
    public function edit(L4Number $number)
    {
        $sellers = L4Seller::active()->get();
        $buyers = L4Buyer::active()->get();

        return Inertia::render('admin/numbers/edit', [
            'number' => $number,
            'sellers' => $sellers,
            'buyers' => $buyers,
        ]);
    }

    /**
     * Update the specified number.
     */
    public function update(UpdateNumberRequest $request, L4Number $number)
    {
        $number->update($request->validated());

        return redirect()->route('numbers.show', $number)
            ->with('success', 'Number updated successfully.');
    }

    /**
     * Remove the specified number.
     */
    public function destroy(L4Number $number)
    {
        $number->delete();

        return redirect()->route('numbers.index')
            ->with('success', 'Number deleted successfully.');
    }
}