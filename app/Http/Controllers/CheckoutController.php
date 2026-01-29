<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Reservation;

class CheckoutController extends Controller
{
    public function confirmation(Request $request)
    {
        // Get reservation data from session
        $reservation = session('reservation', [
            'leather' => 'heritage',
            'hardware' => 'antique',
            'monogram' => 'F•L',
            'total_price' => 445,
        ]);

        return view('checkout.confirmation', $reservation);
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
            'shipping_method' => 'required|in:standard,express',
            'card_name' => 'required_if:payment_method,card',
            'card_number' => 'required_if:payment_method,card',
            'expiry_date' => 'required_if:payment_method,card',
            'cvc' => 'required_if:payment_method,card',
            'terms' => 'required|accepted',
        ]);

        // Get reservation data
        $reservation = session('reservation');

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'VRD-' . strtoupper(uniqid()),
            'leather_type' => $reservation['leather'],
            'hardware_type' => $reservation['hardware'],
            'monogram' => $reservation['monogram'] ?? null,
            'total_price' => $reservation['total_price'],
            'shipping_address' => json_encode([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'zip_code' => $validated['zip_code'],
                'country' => $validated['country'],
                'phone' => $validated['phone'],
            ]),
            'shipping_method' => $validated['shipping_method'],
            'status' => 'pending',
        ]);

        // Clear reservation session
        session()->forget('reservation');

        // Redirect to success page
        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}