<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\L4Seller;
use Illuminate\Http\Request;

class SellerActionController extends Controller
{
    /**
     * Handle seller actions (ban, unban).
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:l4_sellers,id',
            'action' => 'required|in:ban,unban',
        ]);

        $seller = L4Seller::findOrFail($request->seller_id);
        $message = '';
        
        switch ($request->action) {
            case 'ban':
                $seller->update(['status' => 'banned']);
                $message = 'Seller banned successfully.';
                break;
            case 'unban':
                $seller->update(['status' => 'active']);
                $message = 'Seller unbanned successfully.';
                break;
            default:
                $message = 'Invalid action.';
                break;
        }

        return back()->with('success', $message);
    }
}