<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Assurez-vous d'avoir un modèle Order
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function goToConfirmation()
    {
        return view('checkout.confirmation');
    }

    public function storeCustomization(Request $request)
    {
        // Validate customization form
        $validated = $request->validate([
            'leather' => 'required|string|max:50',
            'hardware' => 'required|string|max:50',
            'monogram' => 'nullable|string|max:10',
            'total_price' => 'required|numeric',
        ]);
        
        // Store in session for later use
        session(['customization_details' => $validated]);
        
        // Redirect to confirmation page
        return redirect()->route('checkout.confirmation');
    }

    public function confirmation(Request $request)
    {
        // Get customization from session
        $customization = session('customization_details');
        
        if (!$customization) {
            // If no customization in session, redirect back
            return redirect()->route('reservation.personalize')
                ->with('error', 'Please customize your satchel first.');
        }
        
        return view('checkout.confirmation', $customization);
    }

    public function process(Request $request)
    {
        // Get customization from session
        $customization = session('customization_details');
        
        if (!$customization) {
            return redirect()->route('reservation.personalize')
                ->with('error', 'Your session has expired. Please start over.');
        }
        
        // Validate checkout form
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            // ... other validation rules
        ]);
        
        // Merge customization with checkout data
        $orderData = array_merge($customization, $validated);
        
        // Create order
        $order = Order::create([
            'order_number' => 'VRD-' . now()->format('Ymd') . '-' . rand(1000, 9999),
            'leather_type' => $customization['leather'],
            'hardware_type' => $customization['hardware'],
            'monogram' => $customization['monogram'],
            'total_price' => $customization['total_price'],
            // ... other fields from $validated
        ]);
        
        // Clear session
        session()->forget('customization_details');
        
        // Redirect to success page
        return redirect()->route('checkout.success', $order->order_number);
    }
    
    public function success($order)
    {
        // Récupérer la commande depuis la base de données
        $order = Order::where('order_number', $order)
            ->orWhere('id', $order)
            ->firstOrFail();
            
        return view('checkout.success', compact('order'));
    }
}