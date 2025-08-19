<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\L4Buyer;
use App\Models\L4Seller;
use App\Models\L4Number;
use App\Models\L4Invoice;
use App\Models\L4Payment;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_buyers' => L4Buyer::count(),
            'active_buyers' => L4Buyer::active()->count(),
            'banned_buyers' => L4Buyer::banned()->count(),
            'total_sellers' => L4Seller::count(),
            'active_sellers' => L4Seller::active()->count(),
            'banned_sellers' => L4Seller::banned()->count(),
            'total_numbers' => L4Number::count(),
            'available_numbers' => L4Number::available()->count(),
            'rented_numbers' => L4Number::rented()->count(),
            'pending_invoices' => L4Invoice::pending()->count(),
            'total_revenue' => L4Payment::credits()->sum('amount'),
            'monthly_revenue' => L4Payment::credits()
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
        ];

        $recent_buyers = L4Buyer::with(['numbers', 'invoices'])
            ->latest('last_activity')
            ->take(5)
            ->get();

        $recent_invoices = L4Invoice::with('buyer')
            ->pending()
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('admin/dashboard', [
            'stats' => $stats,
            'recent_buyers' => $recent_buyers,
            'recent_invoices' => $recent_invoices,
        ]);
    }
}