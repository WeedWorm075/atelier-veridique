<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; // Assuming you have a Reservation model

class ReservationController extends Controller
{
    public function personalize(Request $request)
    {
        // Get customization from session or request
        $customization = [
            'leather' => $request->old('leather', 'heritage'),
            'hardware' => $request->old('hardware', 'antique'),
            'monogram' => $request->old('monogram', 'F•L'),
            'total_price' => $request->old('total_price', 445),
        ];

        return view('reservation.personalize', $customization);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'leather' => 'required|string',
            'hardware' => 'required|string',
            'monogram' => 'nullable|string',
            'total_price' => 'required|numeric',
        ]);

        // Store in session for checkout
        session(['reservation' => $validated]);

        return redirect()->route('checkout.confirmation')->withInput($validated);
    }
}