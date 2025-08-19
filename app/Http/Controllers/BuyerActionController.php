<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\L4Buyer;
use App\Models\L4Number;
use Illuminate\Http\Request;

class BuyerActionController extends Controller
{
    /**
     * Handle buyer actions (ban, unban, stop numbers).
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'buyer_id' => 'required|exists:l4_buyers,id',
            'action' => 'required|in:ban,unban,stop_numbers',
        ]);

        $buyer = L4Buyer::findOrFail($request->buyer_id);
        $message = '';
        
        switch ($request->action) {
            case 'ban':
                $buyer->update(['status' => 'banned']);
                $message = 'Buyer banned successfully.';
                break;
            case 'unban':
                $buyer->update(['status' => 'active']);
                $message = 'Buyer unbanned successfully.';
                break;
            case 'stop_numbers':
                // Move all active numbers to terminal state
                L4Number::where('buyer_id', $buyer->id)
                    ->whereIn('status', ['available', 'rented'])
                    ->update([
                        'status' => 'cancelled',
                        'completed_at' => now()
                    ]);
                $message = 'All active numbers stopped for buyer.';
                break;
            default:
                $message = 'Invalid action.';
                break;
        }

        return back()->with('success', $message);
    }
}